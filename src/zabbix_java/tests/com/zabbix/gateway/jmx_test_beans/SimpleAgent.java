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

import javax.management.*;
import java.lang.management.*;

public class SimpleAgent
{
	private MBeanServer mbs = null;

	public SimpleAgent()
	{
		mbs = ManagementFactory.getPlatformMBeanServer();

		Hello helloBean = new Hello();
		ObjectName helloName = null;

		try
		{
			helloName = new ObjectName("FOO:name=HelloBean");
			mbs.registerMBean(helloBean, helloName);
		}
		catch(Exception e)
		{
			e.printStackTrace();
		}
	}

	// Utility method: so that the application continues to run
	private static void waitForEnterPressed()
	{
		try
		{
			System.out.println("Press  to continue...");
			System.in.read();
		}
		catch (Exception e)
		{
			e.printStackTrace();
		}
	}

	public static void main(String argv[])
	{
		SimpleAgent agent = new SimpleAgent();
		System.out.println("SimpleAgent is running...");
		SimpleAgent.waitForEnterPressed();
	}
}
