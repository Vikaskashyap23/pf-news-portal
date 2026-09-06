<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DomainController extends Controller
{
    /**
     * Show domains for a website.
     */
    public function index(Website $website)
    {
        $domains = $website->domains()
            ->latest()
            ->paginate(10);

        return view('admin.domains.index', compact(
            'website',
            'domains'
        ));
    }

    /**
     * Show create domain form.
     */
    public function create(Website $website)
    {
        return view('admin.domains.create', compact('website'));
    }

    /**
     * Store a new domain.
     */
    public function store(Request $request, Website $website)
    {
        $validated = $request->validate([
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!https?:\/\/)(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/',
            ],
            'type' => [
                'required',
                'in:subdomain,custom',
            ],
            'is_primary' => [
                'nullable',
                'boolean',
            ],
        ], [
            'domain.regex' => 'Please enter a valid domain, for example: example.com',
        ]);

        $domainName = strtolower(trim($validated['domain']));

        // Prevent duplicate domain globally.
        if (Domain::where('domain', $domainName)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'domain' => 'This domain is already connected to a website.',
                ]);
        }

        $isPrimary = $request->boolean('is_primary');

        // If this is the first domain, make it primary automatically.
        if ($website->domains()->count() === 0) {
            $isPrimary = true;
        }

        // Only one primary domain per website.
        if ($isPrimary) {
            $website->domains()
                ->where('is_primary', true)
                ->update([
                    'is_primary' => false,
                ]);
        }
$website->domains()->create([
    'domain' => $domainName,
    'type' => $validated['type'],
    'is_primary' => $isPrimary,
    'status' => 'pending',
    'verification_token' => Str::random(40),
    'verification_method' => 'dns_txt',
]);

        return redirect()
            ->route('admin.websites.domains.index', $website)
            ->with('success', 'Domain added successfully.');
    }

    /**
     * Show edit domain form.
     */
    public function edit(Website $website, Domain $domain)
    {
        abort_unless(
            $domain->website_id === $website->id,
            404
        );

        return view('admin.domains.edit', compact(
            'website',
            'domain'
        ));
    }

    /**
     * Update domain.
     */
    public function update(
        Request $request,
        Website $website,
        Domain $domain
    ) {
        abort_unless(
            $domain->website_id === $website->id,
            404
        );

        $validated = $request->validate([
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!https?:\/\/)(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/',
            ],
            'type' => [
                'required',
                'in:subdomain,custom',
            ],
            'is_primary' => [
                'nullable',
                'boolean',
            ],
        ], [
            'domain.regex' => 'Please enter a valid domain, for example: example.com',
        ]);

        $domainName = strtolower(trim($validated['domain']));

        $duplicate = Domain::where('domain', $domainName)
            ->where('id', '!=', $domain->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'domain' => 'This domain is already connected to another website.',
                ]);
        }

        $isPrimary = $request->boolean('is_primary');

        if ($isPrimary) {
            $website->domains()
                ->where('id', '!=', $domain->id)
                ->update([
                    'is_primary' => false,
                ]);
        }

          $domainChanged = $domain->domain !== $domainName;

          $domain->update([
         'domain' => $domainName,
         'type' => $validated['type'],
         'is_primary' => $isPrimary,

    // Domain change hone par verification reset.

    'status' => $domainChanged ? 'pending' : $domain->status,
    'verified_at' => $domainChanged ? null : $domain->verified_at,
    'verification_token' => $domainChanged
        ? Str::random(40)
        : $domain->verification_token,
    'verification_method' => 'dns_txt',
]);

        return redirect()
            ->route('admin.websites.domains.index', $website)
            ->with('success', 'Domain updated successfully.');
    }

        
        /**
 * Verify domain using DNS TXT record.
 */
public function verify(Website $website, Domain $domain)
{
    abort_unless(
        $domain->website_id === $website->id,
        404
    );

    if ($domain->status === 'verified' || $domain->status === 'active') {
        return back()->with('info', 'Domain is already verified.');
    }

    $host = '_newshub-verification.' . $domain->domain;

    $records = dns_get_record($host, DNS_TXT);

    $verified = false;

    foreach ($records as $record) {
        $txt = $record['txt'] ?? '';

        if ($txt === $domain->verification_token) {
            $verified = true;
            break;
        }
    }

    if (! $verified) {
        return back()->withErrors([
            'domain_verification' =>
                'DNS TXT record not found or verification token does not match.',
        ]);
    }

    $domain->update([
        'status' => 'verified',
        'verified_at' => now(),
    ]);

    return back()->with(
        'success',
        'Domain verified successfully.'
    );
}



    /**
     * Delete domain.
     */
    public function destroy(Website $website, Domain $domain)
    {
        abort_unless(
            $domain->website_id === $website->id,
            404
        );

        $wasPrimary = $domain->is_primary;

        $domain->delete();

        // Automatically promote another domain if primary was deleted.
        if ($wasPrimary) {
            $newPrimary = $website->domains()
                ->latest('id')
                ->first();

            if ($newPrimary) {
                $newPrimary->update([
                    'is_primary' => true,
                ]);
            }
        }

        return redirect()
            ->route('admin.websites.domains.index', $website)
            ->with('success', 'Domain deleted successfully.');
    }
}