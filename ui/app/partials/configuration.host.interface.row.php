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


/**
 * @var CPartial $this
 * @var array $data
 */

$snmp_details = (new CDiv(
	(new CFormGrid())
		->setId('snmp_details_#{iface.interfaceid}')
		->addItem([
			(new CLabel(_('SNMP version'), 'label_interfaces_#{iface.interfaceid}_details_version'))
				->setAsteriskMark(),
			new CFormField(
				(new CSelect('interfaces[#{iface.interfaceid}][details][version]'))
					->addOptions(CSelect::createOptionsFromArray([
						SNMP_V1 => _('SNMPv1'),
						SNMP_V2C => _('SNMPv2'),
						SNMP_V3 => _('SNMPv3')
					]))
					->setValue(SNMP_V2C)
					->setFocusableElementId('label_interfaces_#{iface.interfaceid}_details_version')
					->setId('interfaces_#{iface.interfaceid}_details_version')
					->setAttribute('data-prevent-validation-on-change', 1)
			)
		])
		->addItem([
			(new CLabel(_('SNMP community'), 'interfaces[#{iface.interfaceid}][details][community]'))
				->setId('snmp_community_label_#{iface.interfaceid}')
				->setAsteriskMark(),
			(new CFormField(
				(new CTextBox('interfaces[#{iface.interfaceid}][details][community]', '#{iface.details.community}',
					false, DB::getFieldLength('interface_snmp', 'community')
				))
					->setWidth(ZBX_TEXTAREA_STANDARD_WIDTH)
					->setAriaRequired()
			))
				->setId('snmp_community_field_#{iface.interfaceid}')
		])
		->addItem([
			(new CLabel([
				_('Max repetition count'),
				makeHelpIcon(_('Max repetition count is applicable to discovery and walk only.'))
			], 'interfaces[#{iface.interfaceid}][details][max_repetitions]'))
				->setId('snmp_repetition_count_label_#{iface.interfaceid}'),
			(new CFormField(
				(new CNumericBox('interfaces[#{iface.interfaceid}][details][max_repetitions]',
					'#{iface.details.max_repetitions}', 10, false, false, false
				))->setWidth(ZBX_TEXTAREA_TINY_WIDTH)
			))
				->setId('snmp_repetition_count_field_#{iface.interfaceid}')
		])
		->addItem([
			(new CLabel(_('Context name'), 'interfaces[#{iface.interfaceid}][details][contextname]'))
				->setId('snmpv3_contextname_label_#{iface.interfaceid}'),
			(new CFormField(
				(new CTextBox('interfaces[#{iface.interfaceid}][details][contextname]',
					'#{iface.details.contextname}', false, DB::getFieldLength('interface_snmp', 'contextname')
				))
					->setWidth(ZBX_TEXTAREA_STANDARD_WIDTH)
			))
				->setId('snmpv3_contextname_field_#{iface.interfaceid}')
		])
		->addItem([
			(new CLabel(_('Security name'), 'interfaces[#{iface.interfaceid}][details][securityname]'))
				->setId('snmpv3_securityname_label_#{iface.interfaceid}'),
			(new CFormField(
				(new CTextBox('interfaces[#{iface.interfaceid}][details][securityname]',
					'#{iface.details.securityname}', false,
					DB::getFieldLength('interface_snmp', 'securityname')
				))
					->setWidth(ZBX_TEXTAREA_STANDARD_WIDTH)
			))
				->setId('snmpv3_securityname_field_#{iface.interfaceid}')
		])
		->addItem([
			(new CLabel(_('Security level'), 'label_interfaces_#{iface.interfaceid}_details_securitylevel'))
				->setId('snmpv3_securitylevel_label_#{iface.interfaceid}'),
			(new CFormField(
				(new CSelect('interfaces[#{iface.interfaceid}][details][securitylevel]'))
					->addOptions(CSelect::createOptionsFromArray([
						ITEM_SNMPV3_SECURITYLEVEL_NOAUTHNOPRIV => 'noAuthNoPriv',
						ITEM_SNMPV3_SECURITYLEVEL_AUTHNOPRIV => 'authNoPriv',
						ITEM_SNMPV3_SECURITYLEVEL_AUTHPRIV => 'authPriv'
					]))
					->setValue(ITEM_SNMPV3_SECURITYLEVEL_NOAUTHNOPRIV)
					->setFocusableElementId('label_interfaces_#{iface.interfaceid}_details_securitylevel')
					->setId('interfaces_#{iface.interfaceid}_details_securitylevel')
			))
				->setId('snmpv3_securitylevel_field_#{iface.interfaceid}')
		])
		->addItem([
			(new CLabel(_('Authentication protocol'), 'label-authprotocol-#{iface.interfaceid}'))
				->setId('snmpv3_authprotocol_label_#{iface.interfaceid}'),
			(new CFormField(
				(new CSelect('interfaces[#{iface.interfaceid}][details][authprotocol]'))
					->setFocusableElementId('label-authprotocol-#{iface.interfaceid}')
					->addOptions(CSelect::createOptionsFromArray(getSnmpV3AuthProtocols()))
					->setId('interfaces_#{iface.interfaceid}_details_authprotocol')
			))
				->setId('snmpv3_authprotocol_field_#{iface.interfaceid}')
		])
		->addItem([
			(new CLabel(_('Authentication passphrase'),
				'interfaces[#{iface.interfaceid}][details][authpassphrase]'
			))
				->setId('snmpv3_authpassphrase_label_#{iface.interfaceid}'),
			(new CFormField(
				(new CTextBox('interfaces[#{iface.interfaceid}][details][authpassphrase]',
					'#{iface.details.authpassphrase}', false,
					DB::getFieldLength('interface_snmp', 'authpassphrase')
				))
					->setWidth(ZBX_TEXTAREA_STANDARD_WIDTH)
					->disableAutocomplete()
			))
				->setId('snmpv3_authpassphrase_field_#{iface.interfaceid}')
		])
		->addItem([
			(new CLabel(_('Privacy protocol'), 'label-privprotocol-#{iface.interfaceid}'))
				->setId('snmpv3_privprotocol_label_#{iface.interfaceid}'),
			(new CFormField(
				(new CSelect('interfaces[#{iface.interfaceid}][details][privprotocol]'))
					->setFocusableElementId('label-privprotocol-#{iface.interfaceid}')
					->addOptions(CSelect::createOptionsFromArray(getSnmpV3PrivProtocols()))
			))
				->setId('snmpv3_privprotocol_field_#{iface.interfaceid}')
		])
		->addItem([
			(new CLabel(_('Privacy passphrase'), 'interfaces[#{iface.interfaceid}][details][privpassphrase]'))
				->setId('snmpv3_privpassphrase_label_#{iface.interfaceid}'),
			(new CFormField(
				(new CTextBox('interfaces[#{iface.interfaceid}][details][privpassphrase]',
					'#{iface.details.privpassphrase}', false,
					DB::getFieldLength('interface_snmp', 'privpassphrase')
				))
					->setWidth(ZBX_TEXTAREA_STANDARD_WIDTH)
					->disableAutocomplete()
			))
				->setId('snmpv3_privpassphrase_field_#{iface.interfaceid}')
		])
		->addItem(
			new CFormField(
				(new CCheckBox('interfaces[#{iface.interfaceid}][details][bulk]', SNMP_BULK_ENABLED))
					->setUncheckedValue(SNMP_BULK_DISABLED)
					->setLabel(_('Use combined requests'))
			)
		)
))
	->addClass(ZBX_STYLE_HOST_INTERFACE_CELL)
	->addClass(ZBX_STYLE_HOST_INTERFACE_CELL_DETAILS)
	->addClass(ZBX_STYLE_LIST_ACCORDION_ITEM_BODY);

(new CDiv())
	->addItem([
		(new CInput('hidden', 'interfaces[#{iface.interfaceid}][items]', '#{iface.items}'))
			->setAttribute('data-field-type', 'hidden')
			->removeId(),
		(new CInput('hidden', 'interfaces[#{iface.interfaceid}][isNew]', '#{iface.isNew}'))
			->setAttribute('data-field-type', 'hidden')
			->removeId(),
		(new CInput('hidden', 'interfaces[#{iface.interfaceid}][interfaceid]', '#{iface.interfaceid}'))
			->setAttribute('data-field-type', 'hidden')
			->removeId(),
		(new CInput('hidden', 'interfaces[#{iface.interfaceid}][type]', '#{iface.type}'))
			->setAttribute('data-field-type', 'hidden')
			->setId('interface_type_#{iface.interfaceid}'),
		(new CDiv(
			(new CButtonIcon(ZBX_ICON_CHEVRON_DOWN))->addClass(ZBX_STYLE_HOST_INTERFACE_BTN_TOGGLE)
		))->addClass(ZBX_STYLE_HOST_INTERFACE_CELL),
		(new CDiv('#{iface.type_name}'))
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL)
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL_TYPE),
		(new CDiv(
			(new CTextBox('interfaces[#{iface.interfaceid}][ip]', '#{iface.ip}', false, DB::getFieldLength('interface', 'ip')))
				->setErrorContainer('interface_#{iface.interfaceid}_error_container')
				->addClass(ZBX_STYLE_HOST_INTERFACE_INPUT_EXPAND)
				->setWidth(ZBX_TEXTAREA_INTERFACE_IP_WIDTH)
				->setErrorLabel(_('IP address'))
		))
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL)
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL_IP),
		(new CDiv(
			(new CTextBox('interfaces[#{iface.interfaceid}][dns]', '#{iface.dns}', false, DB::getFieldLength('interface', 'dns')))
				->setErrorContainer('interface_#{iface.interfaceid}_error_container')
				->addClass(ZBX_STYLE_HOST_INTERFACE_INPUT_EXPAND)
				->setWidth(ZBX_TEXTAREA_INTERFACE_DNS_WIDTH)
				->setErrorLabel(_('DNS name'))
		))
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL)
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL_DNS),
		(new CDiv(
			(new CRadioButtonList('interfaces[#{iface.interfaceid}][useip]', null))
				->addValue('IP', INTERFACE_USE_IP, 'interfaces[#{iface.interfaceid}][useip]['.INTERFACE_USE_IP.']')
				->addValue('DNS', INTERFACE_USE_DNS, 'interfaces[#{iface.interfaceid}][useip]['.INTERFACE_USE_DNS.']')
				->addClass(ZBX_STYLE_HOST_INTERFACE_CELL_USEIP)
				->addClass(ZBX_STYLE_HOST_INTERFACE_INPUT_EXPAND)
				->setModern()
		))
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL)
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL_USEIP),
		(new CDiv(
			(new CTextBox('interfaces[#{iface.interfaceid}][port]', '#{iface.port}', false, DB::getFieldLength('interface', 'port')))
				->setErrorContainer('interface_#{iface.interfaceid}_error_container')
				->setWidth(ZBX_TEXTAREA_INTERFACE_PORT_WIDTH)
				->addClass(ZBX_STYLE_HOST_INTERFACE_INPUT_EXPAND)
				->setAriaRequired()
				->setErrorLabel(_('Port'))
		))
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL)
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL_PORT),
		(new CDiv([
			(new CInput('radio', 'interface_main_#{iface.type}', '#{iface.interfaceid}'))
				->addClass(ZBX_STYLE_CHECKBOX_RADIO)
				->addClass(ZBX_STYLE_HOST_INTERFACE_BTN_MAIN_INTERFACE)
				->setId('interface_main_#{iface.interfaceid}'),
			(new CLabel(new CSpan(), 'interface_main_#{iface.interfaceid}'))
				->addClass('checkboxLikeLabel')
				->addStyle('height: 16px; width: 16px;')
		]))
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL)
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL_DEFAULT),
		(new CDiv(
			(new CButtonLink(_('Remove')))->addClass(ZBX_STYLE_HOST_INTERFACE_BTN_REMOVE)
		))
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL)
			->addClass(ZBX_STYLE_HOST_INTERFACE_CELL_ACTION),
		(new CDiv())
			->setId('interface_#{iface.interfaceid}_error_container')
			->addClass(ZBX_STYLE_ERROR_CONTAINER),
		$data['is_snmp'] ? $snmp_details : null
	])
	->addClass(ZBX_STYLE_HOST_INTERFACE_ROW)
	->addClass($data['is_snmp'] ? ZBX_STYLE_LIST_ACCORDION_ITEM : null)
	->addClass($data['is_snmp'] ? ZBX_STYLE_LIST_ACCORDION_ITEM_CLOSED : null)
	->setId('interface_row_#{iface.interfaceid}')
	->setAttribute('data-type', '#{iface.type}')
	->setAttribute('data-interfaceid', '#{iface.interfaceid}')
	->show();
