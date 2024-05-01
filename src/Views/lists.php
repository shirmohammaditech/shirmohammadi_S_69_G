<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
<div class="row">
<div class="col-md-4">
  <i class="bi-alarm"></i>
</div>
<div class="col-md-4">
  <div class="col-md-12 m-2">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newListModal">
      New list
    </button>
  </div>
  <div class="col-md-12" id="userLists">
</div>
</div>
<div class="col-md-4"></div>
</div>
</div>


<!-- New List Modal -->
<div class="modal fade" id="newListModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New list</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      <form name="newList">
  <div class="mt-5 mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="createTitle" id="createListTitle" class="form-control" aria-describedby="titleHelp">
    <div id="titleHelp" class="form-text"></div>
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input type="text" name="createDescription" id="createListDescription" class="form-control">
  </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="createListButton" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- New List Modal -->
<div class="modal fade" id="editListModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit list</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      <form name="editList">
  <div class="mt-5 mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="editTitle" id="editListTitle" class="form-control" aria-describedby="titleHelp">
    <div id="titleHelp" class="form-text"></div>
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input type="text" name="editDescription" id="editListDescription" class="form-control">
  </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="editListButton" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
<script>
let listsObject = [];
$(document).ready(function () {
    (function () {
        $.ajax({
            url: '<?php echo base_url()?>' + '/user-lists',
            type: 'POST',
            dataType: 'json',
            data: '',
            success: function (result, status, xhr) {
                if(result.data) {
                    createDom(result.data);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(error);
            }
        });

    })();

    $("#createListButton").click(function () {
        var list = new Object();
        list.title = $('#createListTitle').val();
        list.description = $('#createListDescription').val();

        $.ajax({
            url: '<?php echo base_url()?>' + '/list/create',
            type: 'POST',
            dataType: 'json',
            data: list,
            success: function (result, status, xhr) {
		            createDom(result.data);
                let newListModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('newListModal'));
                newListModal.hide();






            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });

    });


    $("#editListButton").click(function () {
        var list = new Object();
        list.id = $('#editListButton').data('id');
        list.title = $('#editListTitle').val();
        list.description = $('#editListDescription').val();

        $.ajax({
            url: '<?php echo base_url();?>' + '/list/edit',
            type: 'POST',
            dataType: 'json',
            data: list,
            success: function (result, status, xhr) {
		        createDom(result.data);
            let editListModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editListModal'));
            editListModal.hide();


            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });

    });


});


function createDom(model) {
  if(model) {
    $("#userLists").empty();
    listsObject = [];
    for(let id in model) {
      if (!model.hasOwnProperty(id)) {
        break;
      }

      let dom = $('<div>', {
        class: 'card m-1 p-1',
        id: `card-${id}`,
        html: [
          $('<a>', {
            text: `${model[id].title}`,
            href: '<?php echo base_url();?>/list-items?id='+`${id}`
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
                            }).on('click', null, `${id}`, deleteList),
                            $('<button>', {
                                class: 'btn',
                                text: 'Edit'
                            }).on('click', null, [`${model[id].id}`, `${model[id].title}`, `${model[id].description}`], editList)
                        ]
                    })
                ]
            });
            listsObject.push(dom);
            dom = null;
        }
        $("#userLists").append(listsObject);
    }
}  
function deleteList(param)
{
  var list = new Object();
  list.id = param.data;

        $.ajax({
            url: '<?php echo base_url()?>' + '/list/delete',
            type: 'POST',
            dataType: 'json',
            data: list,
            success: function (result, status, xhr) {
		            createDom(result.data);


            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });


        
}

function editList(param)
{
  console.log(param.data[1]);
  let editListModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editListModal'));
  editListModal.show();
  $('#editListTitle').val(param.data[1]);
  $('#editListDescription').val(param.data[2]);
  $('#editListButton').data('id', param.data[0]);
}

</script>
</body>    
</html>