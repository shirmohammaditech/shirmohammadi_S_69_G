<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <div class="col-md-12 m-2">
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newItemModal">
            New Item
          </button>
        </div>
        <div class="col-md-12" id="listItems">
        </div>
      </div>
      <div class="col-md-4"></div>
    </div>
  </div>


  <!-- New Item Modal -->
  <div class="modal fade" id="newItemModal" tabindex="-1" aria-labelledby="new item" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="new item">New Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form name="newItem">
          <div class="mt-5 mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="createTitle" id="createItemTitle" class="form-control" aria-describedby="titleHelp">
            <div id="titleHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <input type="text" name="createDescription" id="createItemDescription" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="createItemButton" class="btn btn-primary">Save changes</button>
          </form>
          </div>
        </div>
      </div>
    </div>


<!-- Edit item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">  
      <form name="editList">
        <div class="mt-5 mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" name="editTitle" id="editItemTitle" class="form-control" aria-describedby="titleHelp">
          <div id="titleHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <input type="text" name="editDescription" id="editItemDescription" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="editItemButton" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
<script>
let itemsObject = [];
$(document).ready(function () {
  (function () {
    $.ajax({
      url: '<?php echo base_url()?>' + '/list-items',
      type: 'POST',
      dataType: 'json',
      data: '',
      success: function (result, status, xhr) {
        if(result.data) {
          createDom(result.data);
        }
      },
      error: function (xhr, status, error) {
        console.log(error);
      }
    });
  })();

  $("#createItemButton").click(function () {
    var item = new Object();
    item.title = $('#createItemTitle').val();
    item.description = $('#createItemDescription').val();
    item.shopping_list_id = '<?php echo $list_id;?>';
    $.ajax({
      url: '<?php echo base_url()?>' + '/item/create',
      type: 'POST',
      dataType: 'json',
      data: item,
      success: function (result, status, xhr) {
		    createDom(result.data);
        let newItemModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('newItemModal'));
        newItemModal.hide();
      },
      error: function (xhr, status, error) {
        console.log(error);
      }
    });
  });

  $("#editItemButton").click(function () {
    var item = new Object();
    item.id = $('#editItemButton').data('id');
    item.title = $('#editItemTitle').val();
    item.description = $('#editItemDescription').val();

    $.ajax({
      url: '<?php echo base_url();?>' + '/item/edit',
      type: 'POST',
      dataType: 'json',
      data: item,
      success: function (result, status, xhr) {
		    createDom(result.data);
        let editItemModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editItemModal'));
        editItemModal.hide();
      },
      error: function (xhr, status, error) {
        console.log(error);
      }
    });
  });
});

function createDom(model) {
  if(model) {
    $("#listItems").empty();
    itemsObject = [];
    for(let id in model) {
      if (!model.hasOwnProperty(id)) {
        break;
      }

      let dom = $('<div>', {
        class: 'card m-1 p-1',
        id: `card-${id}`,
        html: [
          $('<p>', {
            text: `${model[id].title}`
          }),
          $('<i>', {
            text: `${model[id].description}`
          }),
          $('<div>', {
            class: 'col-md-12',
            html: [
              $('<button>', {
                class: 'btn btn-danger',
                text: 'Delete'
              }).on('click', null, `${id}`, deleteItem),
              $('<button>', {
                class: 'btn',
                text: 'Edit'
                }).on('click', null, [`${model[id].id}`, `${model[id].title}`, `${model[id].description}`], editItem)
              ]
            })
          ]
        });
        itemsObject.push(dom);
        dom = null;
      }
      $("#listItems").append(itemsObject);
    }
}  

function deleteItem(param)
{
  var item = new Object();
  item.id = param.data;
  
  $.ajax({
    url: '<?php echo base_url()?>' + '/item/delete',
    type: 'POST',
    dataType: 'json',
    data: item,
    success: function (result, status, xhr) {
		  createDom(result.data);
    },
    error: function (xhr, status, error) {
      console.log(error);
    }
  });
}

function editItem(param)
{
  let editItemModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editItemModal'));
  editItemModal.show();
  $('#editItemTitle').val(param.data[1]);
  $('#editItemDescription').val(param.data[2]);
  $('#editItemButton').data('id', param.data[0]);
}

</script>
</body>    
</html>