/*=========================================================================================
  File Name: form-quill-editor.js
  Description: Quill is a modern rich text editor built for compatibility and extensibility.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: PIXINVENT
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
var fullEditor = null,
  addNewControlGuide = null,
  editCOntrolGuide = null;
(function (window, document, $) {
  'use strict';
  var Font = Quill.import('formats/font');
  Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
  Quill.register(Font, true);

  // Full Editor

  const editorConfiguration = {
    bounds: '#full-container .editor',
    modules: {
      toolbar: [
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'list': 'ordered' }, { 'list': 'bullet' }],
          [{ 'indent': '-1' }, { 'indent': '+1' }],
          [{ 'direction': 'rtl' }], // Right-to-left direction
          ['clean'],
      ],
  },
    theme: 'snow'
  };

  addNewControlGuide = new Quill('#add-new-control-guide .editor', editorConfiguration);
  editCOntrolGuide = new Quill('#edit-control-guide .editor', editorConfiguration);


  var editors = [fullEditor];
})(window, document, jQuery);
