<?php
/**
 * Copyright (c) 2010, PHPMEF
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 
 * * Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 * 
 * * Redistributions in binary form must reproduce the above copyright
 *   notice, this list of conditions and the following disclaimer in the
 *   documentation and/or other materials provided with the distribution.
 * 
 * * Neither the name of PHPMEF nor the names of its contributors may be 
 *   used to endorse or promote products derived from this software without
 *   specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   MEF
 * @package    MEF
 * @subpackage UnitTests
 * @version    $Id: BlobStorageSharedAccessTest.php 25258 2009-08-14 08:40:41Z unknown $
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */


require_once dirname(__FILE__) . '/T_ICalculationEngine.php';


/**
 * Test Calculator class
 */
class T_Calculator
{
	/**
	 * @import T_ICalculationEngine
	 * 
	 * @var T_ICalculationEngine
	 */
	public $FirstEngine;
	
	/**
	 * @import T_ICalculationEngine
	 * @import-metadata CanMultiply
	 * 
	 * @var T_ICalculationEngine
	 */
	public $ConstrainedEngine;
	
	/**
	 * @import-many T_ICalculationEngine
	 * 
	 * @var T_ICalculationEngine[]
	 */
	public $Engines;
	
	/**
	 * @var T_ICalculationEngine
	 */
	private $_firstEngine;
	
	/**
	 * Set first engine
	 * 
	 * @import T_ICalculationEngine
	 * 
	 * @param T_ICalculationEngine $engine
	 */
	public function setFirstEngine($engine)
	{
		$this->_firstEngine = $engine;
	}
	
	/**
	 * Get first engine
	 * 
	 * @return T_ICalculationEngine
	 */
	public function getFirstEngine(){
		return $this->_firstEngine;
	}
	
	/**
	 * @var T_ICalculationEngine[]
	 */
	private $_engines;
	
	/**
	 * Set engines
	 * 
	 * @import-many T_ICalculationEngine
	 * 
	 * @param T_ICalculationEngine[] $engines
	 */
	public function setEngines($engines)
	{
		$this->_engines = $engines;
	}
	
	/**
	 * Get engines
	 * 
	 * @return T_ICalculationEngine[]
	 */
	public function getEngines(){
		return $this->_engines;
	}
}