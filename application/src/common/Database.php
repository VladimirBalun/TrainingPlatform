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

    class Database {
        private static $test_access = [
            'dsn' => 'mysql:host=127.0.0.1;dbname=training;charset=utf8',
            'user' => 'root',
            'pass' => '1234'
        ];
        private static $production_access = [

        ];

        // use '$test_access' or '$production_access'
        public static $access = [
            'dsn' => 'mysql:host=127.0.0.1;dbname=trainig;charset=utf8',
            'user' => 'root',
            'pass' => '1234'
        ];
    }

}