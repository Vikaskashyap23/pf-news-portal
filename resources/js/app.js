
import './bootstrap';

import {
    ClassicEditor,
    Essentials,
    Paragraph,
    Bold,
    Italic,
    Heading,
    Link,
    List,
    BlockQuote,
    Table
} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.ClassicEditor = ClassicEditor;

window.CKEditorPlugins = {
    Essentials,
    Paragraph,
    Bold,
    Italic,
    Heading,
    Link,
    List,
    BlockQuote,
    Table
};

console.log('App js loaded');

