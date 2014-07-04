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

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'MEF_MetadataTest::main');
}

/**
 * Test helpers
 */
require_once dirname(__FILE__) . '/../TestHelper.php';
require_once dirname(__FILE__) . '/../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

/** Test classes */
require_once dirname(__FILE__) . '/_testclasses/T_Calculator.php';
require_once dirname(__FILE__) . '/_testclasses/T_AdditionEngine.php';
require_once dirname(__FILE__) . '/_testclasses/T_MultiplicationEngine.php';

/** MEF */
require_once 'MEF.php';

/** MEF_Container_Default */
require_once 'MEF/Container/Default.php';

/**
 * @category   MEF
 * @package    MEF
 * @subpackage UnitTests
 * @version    $Id: CompositionInitializerTest.php 25258 2009-08-14 08:40:41Z unknown $
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class MEF_MetadataTest extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
    }
    
    public static function main()
    {
        $suite  = new PHPUnit_Framework_TestSuite("MEF_MetadataTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }
   
    /**
     * Test setup
     */
    protected function setUp()
    {
    }
    
    /**
     * Test teardown
     */
    protected function tearDown()
    {
    }
    
    /**
     * Test metadata
     */
    public function testGetMetadataForClass()
    {
    	// Create new T_Calculator instance
    	$calculator = new T_Calculator();
    	
    	// Satisfy dynamic imports
        $CompositionInitializer = new MEF_CompositionInitializer(
        	new MEF_Container_Default());
        $CompositionInitializer->satisfyImports($calculator);
        
        // Get metadata
        $metadata = $CompositionInitializer->getMetadataForClass('T_MultiplicationEngine');
        
        // Assertions
        $this->assertEquals(1, count($metadata));
        $this->assertEquals('CanMultiply', $metadata[0]);
    }
}

// Call MEF_MetadataTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "MEF_MetadataTest::main") {
    MEF_MetadataTest::main();
}
