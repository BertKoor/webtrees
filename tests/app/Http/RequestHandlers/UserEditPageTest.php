<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2025 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Fisharebest\Webtrees\Http\RequestHandlers;

use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use Fisharebest\Webtrees\Services\EmailService;
use Fisharebest\Webtrees\Services\GedcomImportService;
use Fisharebest\Webtrees\Services\MessageService;
use Fisharebest\Webtrees\Services\ModuleService;
use Fisharebest\Webtrees\Services\TreeService;
use Fisharebest\Webtrees\Services\UserService;
use Fisharebest\Webtrees\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UserEditPage::class)]
class UserEditPageTest extends TestCase
{
    protected static bool $uses_database = true;

    public function testHandler(): void
    {
        $mail_service    = new EmailService();
        $module_service  = new ModuleService();
        $tree_service    = new TreeService(new GedcomImportService());
        $user_service    = new UserService();
        $message_service = new MessageService($mail_service, $user_service);
        $user            = $user_service->create('user', 'real', 'email', 'pass');
        $handler         = new UserEditPage($message_service, $module_service, $tree_service, $user_service);
        $request         = self::createRequest(RequestMethodInterface::METHOD_GET, ['user_id' => (string) $user->id()]);
        $response        = $handler->handle($request);

        self::assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
