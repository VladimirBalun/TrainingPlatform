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

namespace Tests\data\service {

    use App\Common\Status;
    use App\Data\Entity\AdvertiserEntity;
    use App\Data\Service\AdvertisersService;
    use PHPUnit\Framework\TestCase;

    class AdvertisersServiceTest extends TestCase {

        public function testSignupWithIncorrectUsername() {
            $advertiser = new AdvertiserEntity();
            $advertiser->setEmail('not_empty_email@google.com');
            $advertiser->setPassword('bd9abe38537ecd5f65f15352263acea1');
            $advertisers_service = new AdvertisersService();

            $advertiser->setUsername('');
            $this->assertEquals(Status::$SIGNUP_ERROR_INCORRECT_USERNAME, $advertisers_service->signupAdvertiser($advertiser));

            $advertiser->setUsername('max_length_username_more_than_64_symbols____________________________');
            $this->assertEquals(Status::$SIGNUP_ERROR_INCORRECT_USERNAME, $advertisers_service->signupAdvertiser($advertiser));
        }

        public function testSignupWithIncorrectEmail() {
            $advertiser = new AdvertiserEntity();
            $advertiser->setUsername('not_empty_username');
            $advertiser->setPassword('bd9abe38537ecd5f65f15352263acea1');
            $advertisers_service = new AdvertisersService();

            $advertiser->setEmail('');
            $this->assertEquals(Status::$SIGNUP_ERROR_INCORRECT_EMAIL, $advertisers_service->signupAdvertiser($advertiser));

            $advertiser->setEmail('max_length_email_more_than_255_symbols______________________________________
                _____________________________________________________________________________________________________
                _____________________________________________________________________________________________________');
            $this->assertEquals(Status::$SIGNUP_ERROR_INCORRECT_EMAIL, $advertisers_service->signupAdvertiser($advertiser));
        }

        public function testSignupWithIncorrectPassword() {
            $advertiser = new AdvertiserEntity();
            $advertiser->setUsername('not_empty_username');
            $advertiser->setEmail('not_empty_email@google.com');
            $advertisers_service = new AdvertisersService();

            $advertiser->setPassword('');
            $this->assertEquals(Status::$SIGNUP_ERROR_INCORRECT_PASSWORD, $advertisers_service->signupAdvertiser($advertiser));

            $advertiser->setPassword('password_length_is_more_than_md5_hash_length');
            $this->assertEquals(Status::$SIGNUP_ERROR_INCORRECT_PASSWORD, $advertisers_service->signupAdvertiser($advertiser));

            $advertiser->setPassword('less_than_md5_hash_length');
            $this->assertEquals(Status::$SIGNUP_ERROR_INCORRECT_PASSWORD, $advertisers_service->signupAdvertiser($advertiser));
        }

    }

}
