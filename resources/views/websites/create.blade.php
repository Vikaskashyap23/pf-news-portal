<form method="POST" action="/websites">
    @csrf

    <input type="text" name="name" placeholder="Website Name"><br><br>

    <input type="text" name="slug" placeholder="Slug"><br><br>

    <input type="text" name="language" placeholder="Language"><br><br>

    <input type="text" name="theme" placeholder="Theme"><br><br>

    <input type="text" name="domain" placeholder="Domain"><br><br>

    <button type="submit">Save</button>
</form>