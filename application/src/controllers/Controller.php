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

namespace App\Controllers {

    use RedBeanPHP\R;
    use App\Common\Utils;
    use App\Common\Database;

    class Controller {

        public function __construct() {
            if (Utils::isTestEnvironment()) {
                R::setup(Database::$test_access['dsn'], Database::$test_access['user'], Database::$test_access['pass']);
            } else {
                R::setup(Database::$production_access['dsn'], Database::$production_access['user'], Database::$production_access['pass']);
            }

            R::freeze(true);
        }

        public function __destruct() {
            R::close();
        }

    }

}
