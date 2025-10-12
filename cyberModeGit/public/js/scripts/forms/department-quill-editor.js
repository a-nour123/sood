/*=========================================================================================
  File Name: form-quill-editor.js
  Description: Quill is a modern rich text editor built for compatibility and extensibility.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: PIXINVENT
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
var fullEditor = null,
  addNewDepartmentVision = null,
  addNewDepartmentMessage = null,
  addNewDepartmentMission = null,
  addNewDepartmentObjectives = null,
  addNewDepartmentResponsibilities = null,
  editDepartmentVision = null,
  editDepartmentMessage = null,
  editDepartmentMission = null,
  editDepartmentObjectives = null,
  editDepartmentResponsibilities = null;
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

  addNewDepartmentVision = new Quill('#add-new-department-vision .editor', editorConfiguration);
  addNewDepartmentMessage = new Quill('#add-new-department-message .editor', editorConfiguration);
  addNewDepartmentMission = new Quill('#add-new-department-mission .editor', editorConfiguration);
  addNewDepartmentObjectives = new Quill('#add-new-department-objectives .editor', editorConfiguration);
  addNewDepartmentResponsibilities = new Quill('#add-new-department-responsibilities .editor', editorConfiguration);
  editDepartmentVision = new Quill('#edit-department-vision .editor', editorConfiguration);
  editDepartmentMessage = new Quill('#edit-department-message .editor', editorConfiguration);
  editDepartmentMission = new Quill('#edit-department-mission .editor', editorConfiguration);
  editDepartmentObjectives = new Quill('#edit-department-objectives .editor', editorConfiguration);
  editDepartmentResponsibilities = new Quill('#edit-department-responsibilities .editor', editorConfiguration);

  var editors = [fullEditor];
})(window, document, jQuery);
