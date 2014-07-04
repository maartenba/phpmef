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
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

/**
 * @category   MEF
 * @package    MEF
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class MEF_CompositionInitializer
{
	/**
	 * Composition container
	 * 
	 * @var MEF_Container_ContainerInterface
	 */
	protected $_container;
		
	/**
	 * List of cached instances
	 * 
	 * @var array
	 */
	protected $_instances = array();
	
	/**
	 * Creates a new MEF_CompositionInitializer
	 * 
	 * @param MEF_Container_ContainerInterface $container Composition container
	 */
	public function __construct(MEF_Container_ContainerInterface $container)
	{
		$this->_container = $container;
	}
	
	/**
	 * Satisfy dynamic imports on a given import root object
	 * 
	 * @param mixed $importRoot Import root object
	 */
	public function satisfyImports($importRoot = null)
	{
		if (is_null($importRoot) || !is_object($importRoot))
			throw new MEF_Exception("No valid import root given");
			
		// Walk through import root and satisfy dynamic imports
        $type = new ReflectionClass(get_class($importRoot));
        
		// Loop all properties
        $properties = $type->getProperties();
        foreach ($properties as $property)
        {
        	// Match @import
        	$exportsForMember = $this->_container->findExportsForMember($property, '@import');
        	if (is_array($exportsForMember) && count($exportsForMember) > 0)
        	{
        		$importRoot->{$property->getName()} = $this->_initializeExports($exportsForMember[0]);
        	}
        		
        	// Match @import-many
        	$exportsForMember = $this->_container->findExportsForMember($property, '@import-many');
        	if (is_array($exportsForMember) && count($exportsForMember) > 0)
        	{
        		$importRoot->{$property->getName()} = $this->_initializeExports($exportsForMember);
        	}	
        }
        
		// Loop all methods
        $methods = $type->getMethods();
        foreach ($methods as $method)
        {
        	// Match @import
        	$exportsForMember = $this->_container->findExportsForMember($method, '@import');
        	if (is_array($exportsForMember) && count($exportsForMember) > 0)
        	{
        		$importRoot->{$method->getName()}( $this->_initializeExports($exportsForMember[0]) );
        	}
        		
        	// Match @import-many
        	$exportsForMember = $this->_container->findExportsForMember($method, '@import-many');
        	if (is_array($exportsForMember) && count($exportsForMember) > 0)
        	{
        		$importRoot->{$method->getName()}( $this->_initializeExports($exportsForMember) );
        	}	
        }
	}
	
	/**
	 * Get metadata for class
	 * 
	 * @param string $className
	 * @return array
	 */
	public function getMetadataForClass($className)
	{
		return $this->_container->getMetadataForClass($className);
	}
	
	/**
	 * Initializes a MEF_Export or an array of MEF_Export
	 * 
	 * @param MEF_Export|array $exports
	 * @return mixed
	 */
	protected function _initializeExports($exports)
	{
		// Return value
		$returnValue = array();
		
		// Multiple export instances required?
		$multipleExportInstancesRequired = is_array($exports);
		
		// Work with an array
		if (!is_array($exports))
		{
			$exports = array($exports);
		}
		
		// Build instances!
		foreach ($exports as $export)
		{
			// Export class name
			$exportClassName = $export->getName();
			
			// Build export instance
			$exportInstance = null;
			if (in_array('singleinstance', $export->getMetaData()))
			{
				// Only one instance allowed...
				if (!isset($this->_instances[$export->getName()]))
				{
					$exportInstance = new $exportClassName();
					$this->satisfyImports($exportInstance);
					$this->_instances[$export->getName()] = $exportInstance;
				}
				$exportInstance = $this->_instances[$export->getName()];
			}
			else
			{
				$exportInstance = new $exportClassName();
				$this->satisfyImports($exportInstance);
			}
			
			// Determine export type
			if ($export->getExportType() == 'property')
			{
				$exportInstance = $exportInstance->{$export->getExportMember()};
			}
			else if ($export->getExportType() == 'method')
			{
				$exportInstance = $exportInstance->{$export->getExportMember()}();
			}
			
			// Add to return value
			$returnValue[] = $exportInstance;
			
			// Multiple export instances required?
			if (!$multipleExportInstancesRequired)
			{
				return $returnValue[0];
			}
		}
		
		// Return
		return $returnValue;
	}
}
