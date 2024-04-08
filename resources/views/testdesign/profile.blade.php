@extends('testdesign.layout')

@section('body')
    <div class="container pt-5 mt-5 mt-lg-1">
        <div class="row">
            <div class="col-12">
                <p class="h4 font-weight-bolder text-uppercase headertext-symbol Text-secondary">
                    {{ __('profile.profile') }} :
                </p>
            </div>
        </div>
        <div class="row pt-3 mt-5 mt-lg-1">
            <div class="col-8">
                @if (!isset($profile))
                    <div class="row pt-5 mt-5 mt-lg-1 justify-content-center">
                        <div class="col-12 col-lg-6">
                            <img src="/img/design/not_found.jpg" class="img-fluid d-block" style="margin-inline: auto">
                            <p class="Text-secondary text-center font-weight-bolder h4 mt-5">
                                {{ __('home.no_result') }}
                            </p>
                        </div>
                    </div>
                @else
                    @if (session()->get('error') == 'not_insert')
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                            </button>
                            <span>
                                <b> Danger - </b>ເກີດຂໍ້ຜິດພາດ ກະລຸນາລອງໃໝ່</span>
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
            </div>

            <div class="col-8">
                <form method="POST" action="{{ route('profile') }}">
                    @csrf
                    <div class="form-group my-3">
                        <label for="email">{{ __('profile.email') }}</label>
                        <input type="text" class="form-control" placeholder="email" aria-label="email"
                            aria-describedby="email" id="email" value="{{ $profile->email }}" name="email" required>
                    </div>
                    <div class="form-group my-3">
                        <label for="phone_no">{{ __('profile.phone') }}</label>
                        <input type="text" class="form-control" placeholder="phone_no" aria-label="phone_no"
                            aria-describedby="phone_no" id="phone_no" value="{{ $profile->phone_no }}" name="phone_no"
                            required>
                    </div>
                    <div class="form-group my-3">
                        <label for="name">{{ __('profile.first_name') }}</label>
                        <input type="text" class="form-control" placeholder="name" aria-label="name"
                            aria-describedby="name" id="name" value="{{ $profile->name }}" name="name" required>
                    </div>
                    <div class="form-group my-3">
                        <label for="last_name">{{ __('profile.last_name') }}</label>
                        <input type="text" class="form-control" placeholder="last_name" aria-label="last_name"
                            aria-describedby="last_name" id="last_name" value="{{ $profile->last_name }}" name="last_name"
                            required>
                    </div>
                    <div class="my-4">
                        <button type="submit" class="btn Btn-outline-secondary px-5">
                            {{ __('profile.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <hr />
        <div class="row pt-3 mt-5 mt-lg-1">
            <div class="col-8">
                @if (session()->get('error') == 'password_not_match')
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                        <span>
                            <b> Danger - </b>ລະຫັດຜ່ານບໍ່ຕົງກັນ</span>
                    </div>
                @elseif(session()->get('error') == 'password_invalid')
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                        <span>
                            <b> Danger - </b>ລະຫັດຜ່ານປັດຈຸບັນບໍ່ຖືກຕ້ອງ</span>
                    </div>
                @endif
            </div>
            <div class="col-8">
                <form method="POST" action="{{ route('updatePassword') }}">
                    @csrf
                    <div class="form-group my-3">
                        <label for="password">{{ __('profile.current_password') }}</label>
                        <input type="password" class="form-control" placeholder="password" aria-label="password"
                            aria-describedby="password" id="password" name="current_password" required>
                    </div>
                    <div class="form-group my-3">
                        <label for="password">{{ __('profile.new_password') }}</label>
                        <input type="password" class="form-control" placeholder="password" aria-label="password"
                            aria-describedby="password" id="password" name="new_password" required>
                    </div>
                    <div class="my-4">
                        <button type="submit" class="btn Btn-outline-secondary px-5">
                            {{ __('profile.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
@endsection
