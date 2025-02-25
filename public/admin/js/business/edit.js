$(document).ready(function () {
  // Load Parent Categories // Edit Page
  $.get('/api/categories/parents', function (data) {
    $('#parent-category').append(data.map(category => 
      `<option value="${category.id}" ${category.id == selectedParent ? 'selected' : ''}>${category.name}</option>`
    ));
    // Trigger change to load child categories if parent is already selected
    if (selectedParent) {
      $('#parent-category').trigger('change');
    }
  });

  // Load Child Categories on Parent Selection // Edit Page
  $('#parent-category').on('change', function () {
    var parentId = $(this).val();
    $('#child-category').empty().append('<option value="">Select Child Category</option>');
    if (parentId) {
      $.get(`/api/categories/${parentId}/children`, function (data) {
        $('#child-category').append(data.map(category => 
          `<option value="${category.id}" ${category.id == selectedChild ? 'selected' : ''}>${category.name}</option>`
        ));
      });
    }
  });
});
