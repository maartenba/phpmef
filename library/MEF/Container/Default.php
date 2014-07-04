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
 * @subpackage MEF_Container
 * @version    $Id: Exception.php 28585 2009-09-07 12:12:56Z unknown $
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

/**
 * @category   MEF
 * @package    MEF
 * @subpackage MEF_Container
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class MEF_Container_Default
    extends MEF_Container_ContainerAbstract
    implements MEF_Container_ContainerInterface
{
	/**
	 * Creates a new MEF_Container_Default
	 */
	public function __construct()
	{
		$this->_determineDefinedExports();
	}
	
	/**
	 * Determine defined exports
	 */
	protected function _determineDefinedExports()
	{
		// Reset currently known exports
		$this->_definedExports = array();
		
		// Add all declared classes
		$declaredClasses = get_declared_classes();
		foreach ($declaredClasses as $declaredClass)
		{
			// Get all exports defined on a specific class name
			$possibleExports = $this->_processExportsOnClass($declaredClass);
			
			// Add exports
			foreach ($possibleExports as $possibleImportName => $possibleExport)
			{
				$this->_definedExports[$possibleImportName][] = $possibleExport;
			}
		}
	}
	
	/**
	 * Gets all exports defined on a specific class name
	 * 
	 * @param string $className Classname on which to look for named exports
	 * @return array
	 */
	protected function _processExportsOnClass($className)
	{
		// Found export names
		$foundExportNames = array($className);
		
		// Found metadata
		$foundMetadata = array();
		
		// Fetch type information
		$type = new ReflectionClass($className);
		
		// Get docComment
		$docComment = $type->getDocComment();

		// Any named exports mentioned?
		if (strpos($docComment, '@export ') !== false)
        {
	        // Search for @export contents
	        $commentLines = explode("\n", $docComment);
	        foreach ($commentLines as $commentLine)
	        {
	            if (strpos($commentLine, '@export ') !== false)
	            {
	                $namedExport = trim(substr($commentLine, strpos($commentLine, '@export') + 8));
	                $foundExportNames[] = $namedExport;
	            }
	            
	        	if (strpos($commentLine, '@export-metadata ') !== false)
	            {
	                $namedExportMetadata = trim(substr($commentLine, strpos($commentLine, '@export-metadata') + 17));
	                $foundMetadata[] = $namedExportMetadata;
	            }
	        }
        }
        
        // Build return value
        $returnValue = array();
        foreach ($foundExportNames as $foundExportName)
        {
        	$returnValue[$foundExportName] = new MEF_Export($className, $foundMetadata, 'class');
        }    
        
        // Add member information
        $returnValue = array_merge(
        	$returnValue,
        	$this->_processExportsOnClassMembers($className, $foundMetadata)
        );
        
        // Return
        return $returnValue;
	}	
	
	/**
	 * Gets all exports defined on a specific class' members
	 * 
	 * @param string $className Classname on which to look for members with named exports
	 * @param array  $parentMetadata Parent metadata
	 * @return array
	 */
	protected function _processExportsOnClassMembers($className, $parentMetadata = array())
	{
        // Build return value
        $returnValue = array();   
        
		// Fetch type information
        $type = new ReflectionClass($className);
        
		// Loop all properties
        $properties = $type->getProperties();
        foreach ($properties as $property)
        {
			$returnValue = array_merge(
				$returnValue,
				$this->_processExportsOnMember($className, $property, $parentMetadata)
			);
        }
        
		// Loop all methods
        $methods = $type->getMethods();
        foreach ($methods as $method)
        {
			$returnValue = array_merge(
				$returnValue,
				$this->_processExportsOnMember($className, $method, $parentMetadata)
			);
        }
        
        // Return
        return $returnValue;
	}	
	
	/**
	 * Gets all exports defined on a specific member
	 * 
	 * @param string $className Class name
	 * @param ReflectionProperty|ReflectionMethod $member Member on which to look for members with named exports
	 * @param array $parentMetadata Parent metadata
	 * @return array
	 */
	protected function _processExportsOnMember($className, $member, $parentMetadata = array())
	{
		// Found export names
		$foundExportNames = array();
			
		// Found metadata
		$foundMetadata = $parentMetadata;
		
	    // Get docComment
		$docComment = $member->getDocComment();
	
		// Any named exports mentioned?
		if (strpos($docComment, '@export ') !== false)
	    {
		    // Search for @export contents
		    $commentLines = explode("\n", $docComment);
		    foreach ($commentLines as $commentLine)
		    {
		        if (strpos($commentLine, '@export ') !== false)
		        {
		            $namedExport = trim(substr($commentLine, strpos($commentLine, '@export') + 8));
		            $foundExportNames[] = $namedExport;
		        }
		            
		    	if (strpos($commentLine, '@export-metadata ') !== false)
		        {
		            $namedExportMetadata = trim(substr($commentLine, strpos($commentLine, '@export-metadata') + 17));
		            $foundMetadata[] = $namedExportMetadata;
		        }
		    }
	    }	
	        
        // Build return value
        $returnValue = array(); 

        // Export type
        $exportType = $member instanceof ReflectionProperty ? 'property' : 'method';
        
	    // Build result
	    foreach ($foundExportNames as $foundExportName)  
	    {
	        $returnValue[$foundExportName] = new MEF_Export($className, $foundMetadata, $exportType, $member->getName());
	    }
        
        // Return
        return $returnValue;
	}	
	
	/**
	 * Find exports for named import
	 * 
	 * @param string $namedImport Named import
	 * @param array $requiredMetadata Required metadata
	 * @return array Array of MEF_Export
	 */
	protected function _findExports($namedImport, $requiredMetadata = array())
	{
		// Return value
		$returnValue = array();

		// Get the list of possibilities...
		if (isset($this->_definedExports[$namedImport]))
		{
			$exportsForImport = $this->_definedExports[$namedImport];
			foreach ($exportsForImport as $exportForImport)
			{
				// Required metadata present?
				if (count($requiredMetadata) > 0)
				{
					$difference = array_diff($requiredMetadata, $exportForImport->getMetaData());
					if (count($difference) > 0)
						continue;
				}
				
				// Add export to list
				$returnValue[] = $exportForImport;
			}
		}
		
		// Return
		return $returnValue;
	}
	
	/**
	 * Find exports for member
	 * 
	 * @param ReflectionProperty|ReflectionMethod $member
	 * @param string $type
	 * @return array Array of MEF_Export
	 */
	public function findExportsForMember($member, $type = '@import')
	{
		// Get comment
        $docComment = $member->getDocComment();
        
        // Check for MEF $type
        if (strpos($docComment, $type . ' ') !== false)
        {
        	// Find required metadata
	        $metadata = array();
	        if (strpos($docComment, '@import-metadata ') !== false)
	        {
			    // Search for @import-metadata contents
			    $commentLines = explode("\n", $docComment);
			    foreach ($commentLines as $commentLine)
			    {
			        if (strpos($commentLine, '@import-metadata ') !== false)
			        {
			            $metadata[] = trim(substr($commentLine, strpos($commentLine, '@import-metadata') + 17));
			        }
			    }
	        }
	                	
		    // Search for $type contents
		    $commentLines = explode("\n", $docComment);
		    foreach ($commentLines as $commentLine)
		    {
		        if (strpos($commentLine, $type . ' ') !== false)
		        {
		            $namedImport = trim(substr($commentLine, strpos($commentLine, $type) + strlen($type) + 1));
		            return $this->_findExports($namedImport, $metadata);
		        }
		    }
        }
        
        // Nothing found...
        return array();
	}
	
	/**
	 * Get metadata for class
	 * 
	 * @param string $className
	 * @return array
	 */
	public function getMetadataForClass($className)
	{
		if (isset($this->_definedExports[$className])
		    && count($this->_definedExports[$className]) > 0)
		{
		    return $this->_definedExports[$className][0]->getMetaData();
		}
			
		return array();
	}
}
