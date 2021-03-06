<?php
/**
 * Created by PhpStorm.
 * User: Azure Cloud
 * Date: 10/8/2016
 * Time: 2:20 AM
 */
?>

@if(isSet($userSigned))
    @if($userSigned->loginHash==hash('sha256', 'Anime4A Login Successful'))
        <div id="userBox" style="display: none;">
            <div class="closeBtn">CLOSE</div>
        </div>
    @else
        <div id="userBox" style="display: none;">
            <div class="overlay"></div>
            <div class="closeBtn">CLOSE</div>
            <div class="displayArea">
                <script>
                    $(document).ready(function () {
                        $('.userForm').submit(function(e) {
                            e.preventDefault();
                            var _url = $(this).attr('action');
                            var fData = new FormData($(this)[0]);

                            var thisForm = $(this);
                            $.ajax({
                                url: _url,
                                type: 'post',
                                data: fData,
                                processData: false,
                                contentType: false,
                                async: false,
                                success: function(data){
                                    var temp = $.parseJSON(data);
                                    var completed = temp.completed;

                                    if(completed)
                                    {
                                        location.href = $('#MainUrl').attr('href');
                                    }
                                    else {
                                        var error = temp.error;
                                        thisForm.find('.row>.error>span').html(error);
                                    }
                                }
                            });

                            return false;
                        });
                    });

                    function fb_login(){
                        FB.login(function(response) {
                            if (response.authResponse) {
                                FB.api('/me', {fields: 'id,name,email'}, function(response) {
                                    var requestUrl = $('#MainUrl').attr('href') + '/login-with-facebook';

                                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                    $.ajax({
                                        url: requestUrl,
                                        type: 'post',
                                        data: {'id': response.id, 'username': response.email, _token: CSRF_TOKEN},
                                        async: false,
                                        success: function(data){
                                            var temp = $.parseJSON(data);
                                            var completed = temp.completed;

                                            if(completed)
                                            {
                                                location.href = $('#MainUrl').attr('href');
                                            }
                                            else {
                                                var error = temp.error;
                                                thisForm.find('.row>.error>span').html(error);
                                            }
                                        }
                                    });
                                });
                            }
                            else if (response.status === 'not_authorized') {
                            }
                            else {
                            }
                        }, {
                            scope: 'email'
                        });
                    }

                    function gg_login(googleUser)
                    {
                        var requestUrl = $('base').attr('href') + 'login-with-google';
                        var _id = googleUser.getBasicProfile().getId();
                        var _email = googleUser.getBasicProfile().getEmail();
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: requestUrl,
                            type: 'post',
                            data: {'id': _id, 'username': _email, _token: CSRF_TOKEN},
                            async: false,
                            success: function(data){
                                var temp = $.parseJSON(data);
                                var completed = temp.completed;

                                if(completed)
                                {
                                    location.href = $('#MainUrl').attr('href');
                                }
                                else {
                                    var error = temp.error;
                                    thisForm.find('.row>.error>span').html(error);
                                }
                            }
                        });
                    }
                </script>
                <form action="{{Request::root()}}/register" method="post" enctype="multipart/form-data" id="RegisterForm" class="userForm" tabindex='1'>
                    <div class="row">
                        <div class="error">
                            <span></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col1">
                            <span>Email:</span>
                        </div>
                        <div class="col2">
                            <input type="text" name="username" class="username">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col1">
                            <span>Password:</span>
                        </div>
                        <div class="col2">
                            <input type="password" name="password" class="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col1">
                            <span>Retype Password:</span>
                        </div>
                        <div class="col2">
                            <input type="password" name="password2" class="password2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col1">
                            <span>&nbsp;</span>
                        </div>
                        <div class="col2">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="submitBtn" value="Đăng Ký">
                        </div>
                    </div>
                </form>
                <form action="{{Request::root()}}/login" method="post" enctype="multipart/form-data" id="LoginForm2" class="userForm" tabindex='2'>
                    <div class="row">
                        <div class="error">
                            <span></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col1">
                            <span>Email:</span>
                        </div>
                        <div class="col2">
                            <input type="text" name="username" class="username" tabindex='0'>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col1">
                            <span>Password:</span>
                        </div>
                        <div class="col2">
                            <input type="password" name="password" class="password">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col1">
                            <span>&nbsp;</span>
                        </div>
                        <div class="col2">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="submitBtn" value="Đăng Nhập">
                        </div>
                    </div>

                    <div class="row">
							<div id="fb_login">
								<a onclick="fb_login()">
									<img src="/images/facebook-white.png" id="FbLoginBtn" style="width: 30px;">
									<span>Login with Facebook</span>
								</a>
							</div>
							<div id="gg_login">
								<a id="GGLoginBtn">
									<img src="/images/g+-white.png" style="width: 30px;">
									<span>Login with Google+</span>
								</a>
							</div>
                            <script>startApp();</script>
                    </div>

                </form>
            </div>
        </div>
    @endif
@endif