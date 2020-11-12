<?php

/*
 * Copyright 2018 Vladimir Balun
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 *    You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace App\Common {

    class Status {

        // Signup
        public static $SIGNUP_SUCCESS = 0;
        public static $SIGNUP_ERROR_USERNAME_EXISTS = 1;
        public static $SIGNUP_ERROR_EMAIL_EXISTS = 2;
        public static $SIGNUP_ERROR_INCORRECT_USERNAME = 3;
        public static $SIGNUP_ERROR_INCORRECT_EMAIL = 4;
        public static $SIGNUP_ERROR_INCORRECT_PASSWORD = 5;
        public static $SIGNUP_ERROR_UNKNOWN = 6;

        // Login
        public static $LOGIN_SUCCESS = 0;
        public static $LOGIN_ERROR_INCORRECT_EMAIL_OR_PASSWORD = 1;
        public static $LOGIN_ERROR_UNKNOWN = 2;

    }

}


