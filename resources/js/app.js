import './bootstrap';

import { 

    ClassicEditor,
    Essentials,
    Paragraph,
    Bold,
    Italic
} from 'ckeditor5';

console.log(classicEditor);

import 'ckeditor5/ckeditor5.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.ClassicEditor = ClassicEditor;

window.CKEditorPlugins = {
    Essentials,
    Paragraph,
    Bold,
    Italic
};

console.log("App js loaded");