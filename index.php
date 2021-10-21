<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-LPvXVVAlyPoBSGkX8UddpctDks+1P4HG8MhT7/YwqHtJ40bstjzCqjj+VVVDhsCo" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href='https://cdn.fontcdn.ir/Font/Persian/Sahel/Sahel.css' rel='stylesheet' type='text/css'>
    <style media="screen">
        body {
            font-family: Sahel;
        }
        .swal-footer {
            direction: rtl !important;
            text-align: center !important;
        }
        .swal-text {
            direction: rtl !important;
            text-align: center !important;
        }
    </style>
    <title>مدیریت کاربران</title>
</head>
<body>
    <div class="container-fluid" id="app">
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert bg-dark text-white"><h3>مدیریت کاربران</h3></div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="card">

                    <div class="card-header bg-primary text-white">
                        <h3> افزودن کاربر</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div v-for="item, index in errorMsg"  class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <small>{{item}}
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="full_name" class="form-label">نام و نام خانوادگی</label>
                            <input v-model="name" type="text" class="form-control" id="full_name">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">ایمیل</label>
                            <input v-model="email" type="email" class="form-control" id="exampleInputEmail1">
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">موبایل</label>
                            <input v-model="mobile" type="text" class="form-control" id="mobile">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select v-model="status" class="form-select" aria-label="Default select example">
                                <option value="1">فعال</option>
                                <option value="0">غیر فعال</option>
                            </select>
                        </div>
                        <button @click="addUser" type="button" class="btn btn-primary">ثبت</button>
                    </div>
                </div>
            </div>

            <div class="col-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>همه کاربران</h3>
                    </div>
                    <div class="card-body">
                        <table v-if="allUsers.length" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">نام و نام خانوادگی</th>
                                <th scope="col">ایمیل</th>
                                <th scope="col">موبایل</th>
                                <th scope="col">وضعیت</th>
                                <th scope="col">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item, index in allUsers" :key="index">
                                    <th scope="row">{{index + 1}}</th>
                                    <td>
                                          <p v-if="!item.editMode">{{item.name}}</p>
                                          <input v-else type="text" v-model="editName=item.name" class="form-control">
                                    </td>
                                    <td>
                                        <p v-if="!item.editMode">{{item.email}}</p>
                                        <input v-else type="text" v-model="editEmail=item.email" class="form-control">
                                    </td>
                                    <td>
                                        <p v-if="!item.editMode">{{item.mobileno}}</p>
                                        <input v-else type="text" v-model="editMobile=item.mobileno" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <button @click="changeStatus(item.id, item.status)" class="btn badge" :class="item.statusClass" >{{item.statusText}}</button>
                                    </td>
                                    <td>
                                        <div>
                                            <button @click="delUser(item.id)" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                            <button v-if="!item.editMode" @click="editToggle(index)" class="btn btn-success"><i class="bi bi-pencil"></i></button>
                                            <button v-else @click="editUser(index, item.id)"  class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="alert alert-warning" role="alert">
                            هیچ کاربری وجود ندارد شما اولین کاربر را ایجاد کنید.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>

    <script>
        const app = new Vue({
            el: "#app",
            data: {
                allUsers: [],
                name: '',
                email: '',
                mobile: '',
                status: '',
                editName: '',
                editEmail: '',
                editMobile: '',
                isError: false,
                errorMsg: [],
            },
            methods: {
                allRecords() {
                    var self = this;
                    axios.get('read.php')
                    .then(function (response) {
                        if (response["data"]["status"] == 1) {
                            self.allUsers = response["data"]["data"]
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
                },
                addUser: function () {
                    this.isError = false;
                    this.errorMsg = [];
                    if (this.name == "") {
                        this.isError = true;
                        this.errorMsg.push("لطفا نام و نام خانوادگی را وارد کنید.");
                    }
                    if (this.email == "") {
                        this.isError = true;
                        this.errorMsg.push("لطفا ایمیل را وارد کنید.");
                    }
                    if (this.mobile == "") {
                        this.isError = true;
                        this.errorMsg.push("لطفا موبایل را وارد کنید.");
                    }
                    if (this.isError) {
                        return false;
                    }
                    var self = this;
                    axios.post('add_user.php', {
                        name: this.name,
                        email: this.email,
                        mobile: this.mobile,
                        status: this.status
                    })
                    .then(function (response) {
                        if (response["data"][0]["status"] == 1) {
                            swal({
                                title: "تبریک",
                                text: "کاربر با موفقیت افزوده شد.",
                                icon: "success",
                                timer: 3000,
                                button: false
                            });
                            self.allRecords();
                            self.name = "";
                            self.email = "";
                            self.mobile = "";
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
                },
                changeStatus: function (id, status) {
                    var self = this;
                    axios.get('change_status.php', {
                        params: {
                            user_id: id,
                            status: status,
                        }
                    })
                        .then(function (response) {
                            if (response["data"][0]["status"] == 1) {
                                self.allRecords();
                                swal({
                                    title: "تبریک",
                                    text: "وضعیت کاربر با موفقیت تغییر کرد.",
                                    icon: "success",
                                    button: "تایید",
                                });
                            }
                        })
                },
                delUser: function(id) {
                  swal({
                    title: "توجه",
                    text: "آیا از حذف کاربر مورد نظر مطمئن هستید ؟",
                    icon: "warning",
                    buttons: ["خیر", "بله"],
                    dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      var self = this;
                      axios.get('delete.php?user_id=' + id)
                      .then(function(response) {
                          if (response["data"][0]["status"] == 1) {
                              self.allRecords();
                              swal({
                                title: "تبریک",
                                text: "کاربر با موفقیت حذف شد.",
                                icon: "success",
                              });
                          }
                      })
                      .catch(function(error) {
                          console.log(error);
                      })
                    } else {
                      swal({
                        title: "توجه",
                        text: "کاربر حذف نشد.",
                        icon: "warning",
                        button: true,
                        dangerMode: true,
                      });
                    }
                  });
                },
                editToggle: function(index) {
                    this.allUsers[index]["editMode"] = !this.allUsers[index]["editMode"];
                },
                editUser(index, id) {
                    var self = this;
                    axios.post('edit_user.php', {
                      user_id: id,
                      name: this.editName,
                      email: this.editEmail,
                      mobile: this.editMobile,
                    })
                    .then(function(response) {
                          swal({
                            title: "تبریک",
                            text: "کاربر با موفقیت ویرایش شد.",
                            icon: "success",
                          });
                          self.allRecords();
                    })
                    .catch(function(error) {
                        console.log(error);
                    })
                    this.allUsers[index]["editMode"] = !this.allUsers[index]["editMode"];
                }
            },
            mounted() {
                this.allRecords();
            }
        });
        // app.allRecords()
    </script>

</body>
</html>
