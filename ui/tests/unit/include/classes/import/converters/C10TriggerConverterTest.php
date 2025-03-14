<?php declare(strict_types = 0);
/*
** Copyright (C) 2001-2025 Zabbix SIA
**
** This program is free software: you can redistribute it and/or modify it under the terms of
** the GNU Affero General Public License as published by the Free Software Foundation, version 3.
**
** This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
** without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
** See the GNU Affero General Public License for more details.
**
** You should have received a copy of the GNU Affero General Public License along with this program.
** If not, see <https://www.gnu.org/licenses/>.
**/


use PHPUnit\Framework\TestCase;

class C10TriggerConverterTest extends TestCase {

	public function dataProvider() {
		return [
			['{h1:item.last(0)}=0', '{h1:item.last(0)}=0'],
			[
				'{h1:vfs.fs.size[/var/tmp,pfree].last("#1")}=0 | {h1:vfs.fs.size[/tmp,pfree].last(0)}=0',
				'{h1:vfs.fs.size[/var/tmp,pfree].last("#1")}=0 | {h1:vfs.fs.size[/tmp,pfree].last(0)}=0'
			],
			['{h1:ftp.item.last(0)}=0', '{h1:ftp.item.last(0)}=0'],
			['{h1:ftp,1.last(0)}=0', '{h1:net.tcp.service[ftp,,1].last(0)}=0'],
			[
				'{h1:ftp,1.last(0)} = 0 & {h1:ftp,1.last(0)} = 0',
				'{h1:net.tcp.service[ftp,,1].last(0)} = 0 & {h1:net.tcp.service[ftp,,1].last(0)} = 0'
			],
			[
				'{h1:ntp,{$PORT.NTP}.last(0)}#0 & {h1:ssh,{$PORT.SSH}.last(0)}',
				'{h1:net.tcp.service[ntp,,{$PORT.NTP}].last(0)}#0 & {h1:net.tcp.service[ssh,,{$PORT.SSH}].last(0)}'
			],

			['{h1:ftp.last(0)}=0', '{h1:net.tcp.service[ftp].last(0)}=0'],
			['{h1:ftp,.last(0)}=0', '{h1:net.tcp.service[ftp].last(0)}=0'],
			[
				'{h1:ftp,1.last(0)}=0&{h1:ftp,2.last(0)}=0',
				'{h1:net.tcp.service[ftp,,1].last(0)}=0&{h1:net.tcp.service[ftp,,2].last(0)}=0'
			]
		];
	}

	/**
	 * @dataProvider dataProvider
	 *
	 * @param $expression
	 * @param $expectedResult
	 */
	public function testConvert($expression, $expectedResult) {
		$converter = new C10TriggerConverter();
		$result = $converter->convert($expression);

		$this->assertEquals($expectedResult, $result);
	}

}
