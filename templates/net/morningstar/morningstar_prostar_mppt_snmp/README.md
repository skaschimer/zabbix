
# Morningstar ProStar MPPT by SNMP

## Overview

This template is designed for the effortless deployment of Morningstar ProStar MPPT monitoring by Zabbix via SNMP and doesn't require any external scripts.

## Requirements

Zabbix version: 8.0 and higher.

## Tested versions

This template has been tested on:
- Morningstar ProStar MPPT

## Configuration

> Zabbix should be configured according to the instructions in the [Templates out of the box](https://www.zabbix.com/documentation/8.0/manual/config/templates_out_of_the_box) section.

## Setup

Refer to the vendor documentation.

### Macros used

|Name|Description|Default|
|----|-----------|-------|
|{$BATTERY.TEMP.MIN.WARN}|<p>Battery low temperature warning value</p>|`0`|
|{$BATTERY.TEMP.MAX.WARN}|<p>Battery high temperature warning value</p>|`45`|
|{$BATTERY.TEMP.MIN.CRIT}|<p>Battery low temperature critical value</p>|`-20`|
|{$BATTERY.TEMP.MAX.CRIT}|<p>Battery high temperature critical value</p>|`60`|
|{$VOLTAGE.MIN.WARN}|||
|{$VOLTAGE.MAX.WARN}|||
|{$VOLTAGE.MIN.CRIT}|||
|{$VOLTAGE.MAX.CRIT}|||
|{$CHARGE.STATE.WARN}|<p>disconnect</p>|`2`|
|{$CHARGE.STATE.CRIT}|<p>fault</p>|`4`|
|{$LOAD.STATE.WARN:"lvdWarning"}|<p>lvdWarning</p>|`2`|
|{$LOAD.STATE.WARN:"disconnect"}|<p>disconnect</p>|`5`|
|{$LOAD.STATE.WARN:"override"}|<p>override</p>|`7`|
|{$LOAD.STATE.CRIT:"lvd"}|<p>lvd</p>|`3`|
|{$LOAD.STATE.CRIT:"fault"}|<p>fault</p>|`4`|

### Items

|Name|Description|Type|Key and additional info|
|----|-----------|----|-----------------------|
|Status: Uptime (network)|<p>The time (in hundredths of a second) since the network management portion of the system was last re-initialized.</p>|SNMP agent|status.net.uptime<p>**Preprocessing**</p><ul><li><p>Custom multiplier: `0.01`</p></li></ul>|
|Status: Uptime (hardware)|<p>The amount of time since this host was last initialized. Note that this is different from sysUpTime in the SNMPv2-MIB [RFC1907] because sysUpTime is the uptime of the network management portion of the system.</p>|SNMP agent|status.hw.uptime<p>**Preprocessing**</p><ul><li><p>Check for not supported value: `any error`</p><p>⛔️Custom on fail: Set value to: `0`</p></li><li><p>Custom multiplier: `0.01`</p></li></ul>|
|Array: Voltage|<p>MIB: PROSTAR-MPPT</p><p>Array Voltage</p><p>  Description:Array Voltage</p><p>  Scaling Factor:1.0</p><p>  Units:V</p><p>  Range:[0, 80]</p><p>  Modbus address:0x0013</p>|SNMP agent|array.voltage[arrayVoltage.0]|
|Array: Sweep Vmp|<p>MIB: PROSTAR-MPPT</p><p>Array Vmp</p><p>  Description:Array Max. Power Point Voltage</p><p>  Scaling Factor:1.0</p><p>  Units:V</p><p>  Range:[0.0, 5000.0]</p><p>  Modbus address:0x003D</p>|SNMP agent|array.sweep_vmp[arrayVmp.0]|
|Array: Sweep Voc|<p>MIB: PROSTAR-MPPT</p><p>Array Voc</p><p> Description:Array Open Circuit Voltage</p><p> Scaling Factor:1.0</p><p> Units:V</p><p> Range:[0.0, 80.0]</p><p> Modbus address:0x003F</p>|SNMP agent|array.sweep_voc[arrayVoc.0]|
|Array: Sweep Pmax|<p>MIB: PROSTAR-MPPT</p><p>Array Max. Power (sweep)</p><p> Description:Array Max. Power (last sweep)</p><p> Scaling Factor:1.0</p><p> Units:W</p><p> Range:[0.0, 500]</p><p> Modbus address:0x003E</p>|SNMP agent|array.sweep_pmax[arrayMaxPowerSweep.0]|
|Battery: Charge State|<p>MIB: PROSTAR-MPPT</p><p>Charge State</p><p>  Description:Control State</p><p>  Modbus address:0x0021</p><p></p><p>  0: Start</p><p>  1: NightCheck</p><p>  2: Disconnect</p><p>  3: Night</p><p>  4: Fault</p><p>  5: BulkMppt</p><p>  6: Absorption</p><p>  7: Float</p><p>  8: Equalize</p><p>  9: Slave</p><p>  10: Fixed</p>|SNMP agent|charge.state[chargeState.0]<p>**Preprocessing**</p><ul><li><p>Discard unchanged with heartbeat: `1h`</p></li></ul>|
|Battery: Battery Voltage discovery|<p>MIB: PROSTAR-MPPT</p>|SNMP agent|battery.voltage.discovery[batteryTerminalVoltage.0]|
|Battery: Target Voltage|<p>MIB: PROSTAR-MPPT</p><p>Target Voltage</p><p> Description:Target Regulation Voltage</p><p> Scaling Factor:1.0</p><p> Units:V</p><p> Range:[0.0, 80.0]</p><p> Modbus address:0x0024</p>|SNMP agent|target.voltage[targetVoltage.0]<p>**Preprocessing**</p><ul><li><p>Discard unchanged with heartbeat: `1h`</p></li></ul>|
|Battery: Charge Current|<p>MIB: PROSTAR-MPPT</p><p>Charge Current</p><p>  Description:Charge Current</p><p>  Scaling Factor:1.0</p><p>  Units:A</p><p>  Range:[0, 40]</p><p>  Modbus address:0x0010</p>|SNMP agent|charge.current[chargeCurrent.0]|
|Load: State|<p>MIB: PROSTAR-MPPT</p><p>Load State</p><p> Description:Load State</p><p> Modbus address:0x002E</p><p></p><p> 0: Start</p><p>1: Normal</p><p>2: LvdWarning</p><p>3: Lvd</p><p>4: Fault</p><p>5: Disconnect</p><p>6: NormalOff</p><p>7: Override</p><p>8: NotUsed</p>|SNMP agent|load.state[loadState.0]<p>**Preprocessing**</p><ul><li><p>Discard unchanged with heartbeat: `1h`</p></li></ul>|
|Load: Voltage|<p>MIB: PROSTAR-MPPT</p><p>Load Voltage</p><p> Description:Load Voltage</p><p> Scaling Factor:1.0</p><p> Units:V</p><p> Range:[0, 80]</p><p> Modbus address:0x0014</p>|SNMP agent|load.voltage[loadVoltage.0]|
|Load: Current|<p>MIB: PROSTAR-MPPT</p><p>Load Current</p><p> Description:Load Current</p><p> Scaling Factor:1.0</p><p> Units:A</p><p> Range:[0, 60]</p><p> Modbus address:0x0016</p>|SNMP agent|load.current[loadCurrent.0]|
|Temperature: Ambient|<p>MIB: PROSTAR-MPPT</p><p>Ambient Temperature</p><p> Description:Ambient Temperature</p><p> Scaling Factor:1.0</p><p> Units:deg C</p><p> Range:[-128, 127]</p><p> Modbus address:0x001C</p>|SNMP agent|temp.ambient[ambientTemperature.0]|
|Temperature: Battery|<p>MIB: PROSTAR-MPPT</p><p>Battery Temperature</p><p>  Description:Battery Temperature</p><p>  Scaling Factor:1.0</p><p>  Units:deg C</p><p>  Range:[-128, 127]</p><p>  Modbus address:0x001B</p>|SNMP agent|temp.battery[batteryTemperature.0]|
|Temperature: Heatsink|<p>MIB: PROSTAR-MPPT</p><p>Heatsink Temperature</p><p> Description:Heatsink Temperature</p><p> Scaling Factor:1.0</p><p> Units:deg C</p><p> Range:[-128, 127]</p><p> Modbus address:0x001A</p>|SNMP agent|temp.heatsink[heatsinkTemperature.0]|
|Counter: Charge Amp-hours|<p>MIB: PROSTAR-MPPT</p><p>Ah Charge (Resettable)</p><p> Description:Ah Charge (Resettable)</p><p> Scaling Factor:0.1</p><p> Units:Ah</p><p> Range:[0.0, 4294967294]</p><p> Modbus addresses:H=0x0026 L=0x0027</p>|SNMP agent|counter.charge_amp_hours[ahChargeResettable.0]<p>**Preprocessing**</p><ul><li><p>Custom multiplier: `0.1`</p></li></ul>|
|Counter: Charge KW-hours|<p>MIB: PROSTAR-MPPT</p><p>kWh Charge (Resettable)</p><p>Description:Kilowatt Hours Charge (Resettable)</p><p>Scaling Factor:1.0</p><p>Units:kWh</p><p>Range:[0.0, 65535]</p><p>Modbus address:0x002A</p>|SNMP agent|counter.charge_kw_hours[kwhChargeResettable.0]|
|Counter: Load Amp-hours|<p>MIB: PROSTAR-MPPT</p><p>Description:Ah Load (Resettable)</p><p>Scaling Factor:0.1</p><p>Units:Ah</p><p>Range:[0.0, 4294967294]</p><p>Modbus addresses:H=0x0032 L=0x0033</p>|SNMP agent|counter.load_amp_hours[ahLoadResettable.0]<p>**Preprocessing**</p><ul><li><p>Custom multiplier: `0.1`</p></li></ul>|
|Status: Array Faults|<p>MIB: PROSTAR-MPPT</p><p>Description:Array Faults</p><p>Modbus address:0x0022</p>|SNMP agent|status.array_faults[arrayFaults.0]<p>**Preprocessing**</p><ul><li><p>Discard unchanged with heartbeat: `1h`</p></li><li><p>JavaScript: `The text is too long. Please see the template.`</p></li></ul>|
|Status: Load Faults|<p>MIB: PROSTAR-MPPT</p><p>Description:Array Faults</p><p>Modbus address:0x0022</p>|SNMP agent|status.load_faults[loadFaults.0]<p>**Preprocessing**</p><ul><li><p>Discard unchanged with heartbeat: `1h`</p></li><li><p>JavaScript: `The text is too long. Please see the template.`</p></li></ul>|
|Status: Alarms|<p>MIB: PROSTAR-MPPT</p><p>Description:Alarms</p><p>Modbus addresses:H=0x0038 L=0x0039</p>|SNMP agent|status.alarms[alarms.0]<p>**Preprocessing**</p><ul><li><p>Discard unchanged with heartbeat: `1h`</p></li><li><p>JavaScript: `The text is too long. Please see the template.`</p></li></ul>|

### Triggers

|Name|Description|Expression|Severity|Dependencies and additional info|
|----|-----------|----------|--------|--------------------------------|
|Morningstar ProStar MPPT: Status: Device has been restarted|<p>Uptime is less than 10 minutes.</p>|`(last(/Morningstar ProStar MPPT by SNMP/status.hw.uptime)>0 and last(/Morningstar ProStar MPPT by SNMP/status.hw.uptime)<10m) or (last(/Morningstar ProStar MPPT by SNMP/status.hw.uptime)=0 and last(/Morningstar ProStar MPPT by SNMP/status.net.uptime)<10m)`|Info|**Manual close**: Yes|
|Morningstar ProStar MPPT: Status: Failed to fetch data|<p>Zabbix has not received data for items for the last 5 minutes.</p>|`nodata(/Morningstar ProStar MPPT by SNMP/status.net.uptime,5m)=1`|Warning|**Manual close**: Yes|
|Morningstar ProStar MPPT: Battery: Device charge in warning state||`last(/Morningstar ProStar MPPT by SNMP/charge.state[chargeState.0])={$CHARGE.STATE.WARN}`|Warning|**Depends on**:<br><ul><li>Morningstar ProStar MPPT: Battery: Device charge in critical state</li></ul>|
|Morningstar ProStar MPPT: Battery: Device charge in critical state||`last(/Morningstar ProStar MPPT by SNMP/charge.state[chargeState.0])={$CHARGE.STATE.CRIT}`|High||
|Morningstar ProStar MPPT: Load: Device load in warning state||`last(/Morningstar ProStar MPPT by SNMP/load.state[loadState.0])={$LOAD.STATE.WARN:"lvdWarning"}  or last(/Morningstar ProStar MPPT by SNMP/load.state[loadState.0])={$LOAD.STATE.WARN:"override"}`|Warning|**Depends on**:<br><ul><li>Morningstar ProStar MPPT: Load: Device load in critical state</li></ul>|
|Morningstar ProStar MPPT: Load: Device load in critical state||`last(/Morningstar ProStar MPPT by SNMP/load.state[loadState.0])={$LOAD.STATE.CRIT:"lvd"} or last(/Morningstar ProStar MPPT by SNMP/load.state[loadState.0])={$LOAD.STATE.CRIT:"fault"}`|High||
|Morningstar ProStar MPPT: Temperature: Low battery temperature||`max(/Morningstar ProStar MPPT by SNMP/temp.battery[batteryTemperature.0],5m)<{$BATTERY.TEMP.MIN.WARN}`|Warning|**Depends on**:<br><ul><li>Morningstar ProStar MPPT: Temperature: Critically low battery temperature</li></ul>|
|Morningstar ProStar MPPT: Temperature: Critically low battery temperature||`max(/Morningstar ProStar MPPT by SNMP/temp.battery[batteryTemperature.0],5m)<{$BATTERY.TEMP.MIN.CRIT}`|High||
|Morningstar ProStar MPPT: Temperature: High battery temperature||`min(/Morningstar ProStar MPPT by SNMP/temp.battery[batteryTemperature.0],5m)>{$BATTERY.TEMP.MAX.WARN}`|Warning|**Depends on**:<br><ul><li>Morningstar ProStar MPPT: Temperature: Critically high battery temperature</li></ul>|
|Morningstar ProStar MPPT: Temperature: Critically high battery temperature||`min(/Morningstar ProStar MPPT by SNMP/temp.battery[batteryTemperature.0],5m)>{$BATTERY.TEMP.MAX.CRIT}`|High||
|Morningstar ProStar MPPT: Status: Device has "overcurrent" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","overcurrent")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "mosfetSShorted" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","mosfetSShorted")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "software" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","software")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "batteryHvd" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","batteryHvd")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "arrayHvd" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","arrayHvd")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "customSettingsEdit" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","customSettingsEdit")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "rtsShorted" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","rtsShorted")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "rtsNoLongerValid" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","rtsNoLongerValid")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "localTempSensorDamaged" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","localTempSensorDamaged")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "batteryLowVoltageDisconnect" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","batteryLowVoltageDisconnect")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "slaveTimeout" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","slaveTimeout")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "dipSwitchChanged" array faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.array_faults[arrayFaults.0],#3,"like","dipSwitchChanged")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "externalShortCircuit" load faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.load_faults[loadFaults.0],#3,"like","externalShortCircuit")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "overcurrent" load faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.load_faults[loadFaults.0],#3,"like","overcurrent")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "mosfetShorted" load faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.load_faults[loadFaults.0],#3,"like","mosfetShorted")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "software" load faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.load_faults[loadFaults.0],#3,"like","software")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "loadHvd" load faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.load_faults[loadFaults.0],#3,"like","loadHvd")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "highTempDisconnect" load faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.load_faults[loadFaults.0],#3,"like","highTempDisconnect")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "dipSwitchChanged" load faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.load_faults[loadFaults.0],#3,"like","dipSwitchChanged")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "customSettingsEdit" load faults flag||`count(/Morningstar ProStar MPPT by SNMP/status.load_faults[loadFaults.0],#3,"like","customSettingsEdit")=2`|High||
|Morningstar ProStar MPPT: Status: Device has "rtsShorted" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","rtsShorted")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "rtsDisconnected" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","rtsDisconnected")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "heatsinkTempSensorOpen" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","heatsinkTempSensorOpen")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "heatsinkTempSensorShorted" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","heatsinkTempSensorShorted")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "heatsinkTempLimit" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","heatsinkTempLimit")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "inductorTempSensorOpen" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","inductorTempSensorOpen")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "inductorTempSensorShorted" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","inductorTempSensorShorted")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "inductorTempLimit" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","inductorTempLimit")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "currentLimit" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","currentLimit")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "currentMeasurementError" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","currentMeasurementError")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "batterySenseOutOfRange" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","batterySenseOutOfRange")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "batterySenseDisconnected" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","batterySenseDisconnected")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "uncalibrated" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","uncalibrated")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "tb5v" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","tb5v")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "fp10SupplyOutOfRange" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","fp10SupplyOutOfRange")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "mosfetOpen" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","mosfetOpen")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "arrayCurrentOffset" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","arrayCurrentOffset")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "loadCurrentOffset" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","loadCurrentOffset")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "p33SupplyOutOfRange" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","p33SupplyOutOfRange")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "p12SupplyOutOfRange" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","p12SupplyOutOfRange")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "hightInputVoltageLimit" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","hightInputVoltageLimit")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "controllerReset" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","controllerReset")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "loadLvd" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","loadLvd")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "logTimeout" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","logTimeout")=2`|Warning||
|Morningstar ProStar MPPT: Status: Device has "eepromAccessFailure" alarm flag||`count(/Morningstar ProStar MPPT by SNMP/status.alarms[alarms.0],#3,"like","eepromAccessFailure")=2`|Warning||

### LLD rule Battery voltage discovery

|Name|Description|Type|Key and additional info|
|----|-----------|----|-----------------------|
|Battery voltage discovery|<p>Discovery for battery voltage triggers</p>|Dependent item|battery.voltage.discovery<p>**Preprocessing**</p><ul><li><p>JavaScript: `The text is too long. Please see the template.`</p></li></ul>|

### Item prototypes for Battery voltage discovery

|Name|Description|Type|Key and additional info|
|----|-----------|----|-----------------------|
|Battery: Voltage{#SINGLETON}|<p>MIB: PROSTAR-MPPT</p><p>Battery Terminal Voltage</p><p>Description:Battery  Terminal Voltage</p><p>Scaling Factor:1.0</p><p>Units:V</p><p>Range:[0.0, 80.0]</p><p>Modbus address:0x0012</p>|SNMP agent|battery.voltage[batteryTerminalVoltage.0{#SINGLETON}]|

### Trigger prototypes for Battery voltage discovery

|Name|Description|Expression|Severity|Dependencies and additional info|
|----|-----------|----------|--------|--------------------------------|
|Morningstar ProStar MPPT: Battery: Low battery voltage||`max(/Morningstar ProStar MPPT by SNMP/battery.voltage[batteryTerminalVoltage.0{#SINGLETON}],5m)<{#VOLTAGE.MIN.WARN}`|Warning|**Depends on**:<br><ul><li>Morningstar ProStar MPPT: Battery: Critically low battery voltage</li></ul>|
|Morningstar ProStar MPPT: Battery: Critically low battery voltage||`max(/Morningstar ProStar MPPT by SNMP/battery.voltage[batteryTerminalVoltage.0{#SINGLETON}],5m)<{#VOLTAGE.MIN.CRIT}`|High||
|Morningstar ProStar MPPT: Battery: High battery voltage||`min(/Morningstar ProStar MPPT by SNMP/battery.voltage[batteryTerminalVoltage.0{#SINGLETON}],5m)>{#VOLTAGE.MAX.WARN}`|Warning|**Depends on**:<br><ul><li>Morningstar ProStar MPPT: Battery: Critically high battery voltage</li></ul>|
|Morningstar ProStar MPPT: Battery: Critically high battery voltage||`min(/Morningstar ProStar MPPT by SNMP/battery.voltage[batteryTerminalVoltage.0{#SINGLETON}],5m)>{#VOLTAGE.MAX.CRIT}`|High||

## Feedback

Please report any issues with the template at [`https://support.zabbix.com`](https://support.zabbix.com)

You can also provide feedback, discuss the template, or ask for help at [`ZABBIX forums`](https://www.zabbix.com/forum/zabbix-suggestions-and-feedback)

