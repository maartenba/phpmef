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
 * @version    $Id: AllTests.php 28585 2009-09-07 12:12:56Z unknown $
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

/**
 * Test helpers
 */
require_once dirname(__FILE__) . '/../TestHelper.php';
require_once dirname(__FILE__) . '/../TestConfiguration.php';
require_once 'PHPUnit/Framework/TestCase.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'MEF_AllTests::main');
}

require_once 'MEF/MethodImportTest.php';
require_once 'MEF/PropertyImportTest.php';
require_once 'MEF/SingleInstanceImportTest.php';
require_once 'MEF/MetadataTest.php';
require_once 'MEF/NamedImportTest.php';
require_once 'MEF/SettingsImportTest.php';

/**
 * @category   MEF
 * @package    MEF
 * @subpackage UnitTests
 * @version    $Id: AllTests.php 28585 2009-09-07 12:12:56Z unknown $
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class MEF_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Microsoft MEF');

        $suite->addTestSuite('MEF_MethodImportTest');
        $suite->addTestSuite('MEF_PropertyImportTest');
        $suite->addTestSuite('MEF_SingleInstanceImportTest');
        $suite->addTestSuite('MEF_MetadataTest');
        $suite->addTestSuite('MEF_NamedImportTest');
        $suite->addTestSuite('MEF_SettingsImportTest');
        
        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'MEF_AllTests::main') {
    MEF_AllTests::main();
}
