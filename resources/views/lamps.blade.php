@extends('layout')

@section('body')
    <!-- End Navbar -->
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>ຕັ້ງຄ່າໂຄມໄຟ</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            @if (session()->get('error') == 'not_insert')
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                    </button>
                    <span>
                        <b> Danger - </b>ເກີດຂໍ້ຜິດພາດ ກະລຸນາລອງໃໝ່</span>
                </div>
            @elseif(session()->get('error') == 'insert_success')
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                    </button>
                    <span>
                        <b> Success - </b>ບັນທຶກຂໍ້ມູນສຳເລັດ</span>
                </div>
            @elseif(session()->get('error') == 'edit_success')
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                    </button>
                    <span>
                        <b> Success - </b>ແກ້ໄຂຂໍ້ມູນສຳເລັດ</span>
                </div>
            @endif
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div>
                            <h2>ເພີ່ມໂຄມໄຟ</h2>
                            <a class="" type="button" data-toggle="collapse" data-target="#addLampsCollapse"
                                aria-expanded="false" aria-controls="addLampsCollapse">
                                <i class="material-icons">expand_more</i>
                            </a>
                        </div>
                        <div class="collapse" id="addLampsCollapse">
                            <div class="x_content">
                                <form method="POST" action="/addLamp">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ຊື່</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ຊື່ພາສາອັງກິດ</label>
                                                <input type="text" name="en_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ຊື່ພາສາຈີນ</label>
                                                <input type="text" name="cn_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ຊື່ພາສາໄທ</label>
                                                <input type="text" name="th_name" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ລາຄາ</label>
                                                <input type="text" name="price"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ໝວດໝູ່</label>
                                                <select class="form-control" name="category_id" required>
                                                    <option value="">
                                                        ເລືອກ
                                                    </option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->cate_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="bmd-label-floating">ລາຍລະອຽດ</label>
                                            <textarea name="desc" id="myeditorinstance"></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary px-5">ເພີ່ມ</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div>
                            <h2>ຄົ້ນຫາ</h2>
                            <a class="" type="button" data-toggle="collapse" data-target="#searchLampsCollapse"
                                aria-expanded="true" aria-controls="searchLampsCollapse">
                                <i class="material-icons">expand_more</i>
                            </a>
                        </div>
                        <div class="collapse show" id="searchLampsCollapse">
                            <div class="x_content">
                                <form method="GET" action="/manageLamps">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ຊື່</label>
                                                <input type="text" value="{{ Request::input('name') }}" name="name"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ໝວດໝູ່</label>
                                                <select class="form-control" name="category">
                                                    <option value="">
                                                        ເລືອກ
                                                    </option>
                                                    @foreach ($categories as $category)
                                                        <option
                                                            {{ Request::input('category') == $category->id ? 'selected' : '' }}
                                                            value="{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary px-5">ຄົ້ນຫາ</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div>
                            <h2>ໂຄມໄຟທັງໝົດ</h2>
                        </div>
                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            ຊື່
                                        </th>
                                        <th>
                                            ຊື່ພາສາອັງກິດ
                                        </th>
                                        <th>
                                            ຊື່ພາສາຈີນ
                                        </th>
                                        <th>
                                            ຊື່ພາສາໄທ
                                        </th>
                                        <th>
                                            ລາຄາ
                                        </th>
                                        <th>
                                            ໝວດໝູ່
                                        </th>
                                        <th>
                                            ຮູບໜ້າປົກ
                                        </th>
                                        <th>

                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($lamps as $key => $lamp)
                                            <tr>
                                                <td>
                                                    {{ ($pagination['offset'] - 1) * 10 + $key + 1 }}
                                                </td>
                                                <td>
                                                    {{ $lamp->name }}
                                                </td>
                                                <td>
                                                    {{ $lamp->en_name }}
                                                </td>
                                                <td>
                                                    {{ $lamp->cn_name }}
                                                </td>
                                                <td>
                                                    {{ $lamp->th_name }}
                                                </td>
                                                <td>
                                                    {{ number_format($lamp->price) }}
                                                </td>
                                                <td>
                                                    {{ $lamp->cate_name }}
                                                </td>
                                                <td>
                                                    <a href="/lampThumbnail/{{ $lamp->id }}">
                                                        <i class="material-icons">image</i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="/editLamp/{{ $lamp->id }}">
                                                        <i class="material-icons">create</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $pagination['offset'] == 1 ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ Request::route()->getName() }}?name={{ Request::input('name') }}&enabled={{ Request::input('enabled') }}&branch_id={{ Request::input('branch_id') }}&email={{ Request::input('email') }}&page={{ $pagination['offset'] - 1 }}"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item {{ $pagination['offset'] == '1' ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ Request::route()->getName() }}?name={{ Request::input('name') }}&enabled={{ Request::input('enabled') }}&branch_id={{ Request::input('branch_id') }}&email={{ Request::input('email') }}&page=1">1</a>
                    </li>
                    @for ($j = $pagination['offset'] - 25; $j < $pagination['offset'] - 10; $j++)
                        @if ($j % 10 == 0 && $j > 1)
                            <li
                                class="page-item
                        {{ $pagination['offset'] == $j ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ Request::route()->getName() }}?name={{ Request::input('name') }}&enabled={{ Request::input('enabled') }}&branch_id={{ Request::input('branch_id') }}&email={{ Request::input('email') }}&page={{ $j }}">{{ $j }}</a>
                            </li>
                        @else
                        @endif
                    @endfor
                    @for ($i = $pagination['offset'] - 4; $i <= $pagination['offset'] + 4 && $i <= $pagination['offsets']; $i++)
                        @if ($i > 1 && $i <= $pagination['all'])
                            <li class="page-item {{ $pagination['offset'] == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ Request::route()->getName() }}?name={{ Request::input('name') }}&enabled={{ Request::input('enabled') }}&branch_id={{ Request::input('branch_id') }}&email={{ Request::input('email') }}&page={{ $i }}">{{ $i }}</a>
                            </li>
                        @else
                        @endif
                    @endfor
                    @for ($j = $pagination['offset'] + 5; $j <= $pagination['offset'] + 20 && $j <= $pagination['offsets']; $j++)
                        @if ($j % 10 == 0 && $j > 1)
                            <li
                                class="page-item
                        {{ $pagination['offset'] == $j ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ Request::route()->getName() }}?name={{ Request::input('name') }}&enabled={{ Request::input('enabled') }}&branch_id={{ Request::input('branch_id') }}&email={{ Request::input('email') }}&page={{ $j }}">{{ $j }}</a>
                            </li>
                        @else
                        @endif
                    @endfor
                    <li class="page-item {{ $pagination['offset'] == $pagination['offsets'] ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ Request::route()->getName() }}?name={{ Request::input('name') }}&enabled={{ Request::input('enabled') }}&branch_id={{ Request::input('branch_id') }}&email={{ Request::input('email') }}&page={{ $pagination['offset'] + 1 }}"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'powerpaste advcode table lists checklist',
            toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | code | table'
        });
    </script>
@endsection