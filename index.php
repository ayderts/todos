<?php
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
</head>
<body>
<div class="main-section">
    <div class="add-section">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="app/edit.php" method="POST" autocomplete="off">
                    <textarea class="kek" type="text"
                              name="title"
                              placeholder="What do you need to do?"
                              id="titleInput"
                    ></textarea>
                            <input type="text"
                                   name="email"
                                   id="emailInput"
                                   placeholder="E-mail"
                                   value=""/>
                            <input type="text"
                                   name="username"
                                   placeholder="Username"
                                   id="usernameInput"
                                   value=""  />
                            <input type="hidden"
                                   name="id"
                                   placeholder="Username"
                                   id="idInput"
                                   value=""  />
                            <button type="submit">Save changes</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
        <form action="app/add.php" method="POST" autocomplete="off">
            <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text"
                       name="title"
                       style="border-color: #ff6666"
                       placeholder="This field is required" />
                <button type="submit">Add</button>

            <?php }else { ?>
                <textarea class="kek" type="text"
                          name="title"
                          placeholder="What do you need to do?"

                ></textarea>
                <input type="text"
                       name="email"
                       placeholder="E-mail" />
                <input type="text"
                       name="username"
                       placeholder="Username" />
                <input type="hidden"
                       name="itemRole"
                       placeholder="itemRole"
                       id="itemRole"
                       value=""/>
                <button type="submit">Add</button>
            <?php } ?>
        </form>
    </div>
    <?php
    /*$offset = $_POST['offset'];;
    $stmt = $conn->prepare("SELECT *, count(title) OVER() as ROWNUM FROM todos ORDER BY id DESC LIMIT 3 OFFSET ?");
    $todos = $stmt->execute([$offset]);*/
    $todos = $conn->query("SELECT * FROM todos ORDER BY id ");
    ?>
    <div class="show-todo-section" id="pagDiv">
        <?php if($todos->rowCount() <= 0){ ?>
            <div class="todo-item">
                <div class="empty">
                    <img src="img/f.png" width="100%" />
                    <img src="img/Ellipsis.gif" width="80px">
                </div>
            </div>
        <?php } ?>


    </div>
    <div>
        <nav aria-label="Page navigation example">
            <ul id="paginationPage" class="pagination" style="justify-content: center;">

            </ul>
        </nav>
    </div>
    <script src="js/jquery-3.2.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <script lang="text/javascript">
        let pagItem='';
        let butItem='';
        let emptyItem='';
        let offset = 3;
        function pagination(pageNum){
            $('#pagDiv').html('');
            $('#paginationPage').html('');

            $.ajax({
                type: "POST",
                data: {offset: offset * pageNum},
                url: 'app/parse.php',
                success: function(response)
                {
                    const queryString_ = window.location.search;
                    const urlParams_ = new URLSearchParams(queryString_);
                    let itemRole='';
                    let roleForAdd = urlParams_.get('mess')
                    if (roleForAdd == 'admin') {
                        itemRole = 'admin'
                        $(".add-section #itemRole").val(itemRole)
                    }
                    if (roleForAdd == 'guest') {
                        itemRole = 'guest'
                        $(".add-section #itemRole").val(itemRole)
                    }
                    if(response==='[]'){
                        console.log('RESPONSE')
                        emptyItem=`<div class="todo-item">
                                    <div class="empty">
                                        <img src="img/f.png" width="100%" />
                                        <img src="img/Ellipsis.gif" width="80px">
                                     </div>
                                    </div>`
                        $('#pagDiv').append(emptyItem);
                    }
                    var todos = JSON.parse(response);

                    var pageNum_ = Math.ceil(todos[0][5]/3);
                    console.log('PAG',pageNum_)
                    butItem = '';
                    for(let i = 0;i < pageNum_;i++)
                    {
                        butItem +=`<li onclick="pagination(${i})" class="page-item" style="display:table;" ><a class="page-link" href="#">${i+1}</a></li>`
                    }
                    $('#paginationPage').append(butItem);

                    const queryString = window.location.search;
                    const urlParams = new URLSearchParams(queryString);
                    const role = urlParams.get('mess');
                    console.log(role);
                    $.each(todos, function (i){
                        let check_ = '';
                        let h2_ = '';
                        let btn = '';

                        if (role == 'admin') {
                            btn = ` <div style="text-align: center;"><button style="width: 100%;"type="button" id="${todos[i][0]}" class="btn-primary edit-button"   data-toggle="modal" data-target="#exampleModal">EDIT</button></div>`;
                        }

                        if (todos[i][6] == 1 && role == 'admin') {
                            check_ = `<input type="checkbox"
                                       class="check-box"
                                       data-todo-id ="${todos[i][0]}"
                                       checked />`;
                        }
                        else if (role == 'admin') {
                            check_ = `<input type="checkbox"
                                       data-todo-id ="${todos[i][0]}"
                                       class="check-box" />`;
                        }

                        let style_ = role == 'guest' ? 'style="padding-left: 30px;"' : '';

                        if(todos[i][6] == 1) {
                            h2_ = `<h2 class="checked" ${style_} > ${todos[i][1]}</h2>`;
                        }
                        else {
                            h2_ = `<h2 ${style_} > ${todos[i][1]}</h2>`;
                        }

                        pagItem=`<div class="todo-item">
                    <span id="${todos[i][0]}"
                          class="remove-to-do">x</span>${check_}${h2_}
    <br>
    <small>Created: ${todos[i][4]}</small>
    <small>E-mail: ${todos[i][2]}</small>
    <small>Username: ${todos[i][3]}</small>
   ${btn}
</div>`

                        $('#pagDiv').append(pagItem);
                    })
                }
            });

        }

        $(document).ready(function(){
            pagination(0);

            $(document).on('click', '.remove-to-do', function(){
                const id = $(this).attr('id');
                console.log('DELETE ID', id);
                $.post("app/remove.php",
                    {
                        id: id
                    },
                    (data)  => {
                        if(data){
                            $(this).parent().hide(600);
                        }
                    }
                );
            });

            $(document).on('click', '.edit-button', function(){
                console.log('KEK');
                const id = $(this).attr('id');
                // const link = document.querySelector('#selectBtn');
                // const target = link.getAttribute('value');
                console.log(id);

                $.post("app/showEdit.php",
                    {
                        id: id
                    },
                    (data)  => {
                        console.log('DATA',data);
                        var info = JSON.parse(data);
                        $(".modal-body #titleInput").val(info[0]);
                        $(".modal-body #emailInput").val(info[1]);
                        $(".modal-body #usernameInput").val(info[2]);
                        $(".modal-body #idInput").val(info[3]);
                    }
                );

                $("#exampleModal").modal('show');
            });

            $(document).on('click', '.check-box', function(e){
                const id = $(this).attr('data-todo-id');
                $.post('app/check.php',
                    {
                        id: id
                    },
                    (data) => {
                        console.log(data);
                        if(data != 'error'){
                            const h2 = $(this).next();
                            if(data === '1'){
                                h2.removeClass('checked');
                            }else {
                                h2.addClass('checked');
                            }
                        }
                    }
                );
            });
        });
    </script>
</body>
</html>