<?php

namespace Bridges\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BridgesUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
