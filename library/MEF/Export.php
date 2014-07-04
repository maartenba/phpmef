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
 * @version    $Id: Exception.php 28585 2009-09-07 12:12:56Z unknown $
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */

/**
 * @category   MEF
 * @package    MEF
 * @copyright  Copyright (c) 2009, RealDolmen (http://www.realdolmen.com)
 * @license    http://phpazure.codeplex.com/license
 */
class MEF_Export
{
	/*
	 * Export name
	 * 
	 * @var string
	 */
	protected $_name;
	
	/*
	 * Export metadata
	 * 
	 * @var array
	 */
	protected $_metaData;
	
	/**
	 * Export type
	 * 
	 * @var string
	 */
	protected $_exportType;
	
	/**
	 * Export member
	 * 
	 * @var string
	 */
	protected $_exportMember;
	
	/**
	 * Creates a new MEF_Export instance
	 * 
	 * @param string $name		   Export name
	 * @param array  $metaData	   Export metadata
	 * @param string $exportType   Export type
	 * @param string $exportMember Export member
	 */
	public function __construct($name = '', $metaData = array(), $exportType = 'class', $exportMember = null)
	{
		$this->_name	     = $name;
		$this->_metaData     = $metaData;
		$this->_exportType   = $exportType;
		$this->_exportMember = $exportMember;
	}
	
	/**
	 * Get export name
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
	 * Set export name
	 * 
	 * @param string $value
	 * @return MEF_Export
	 */
	public function setName($value = '')
	{
		$this->_name = $value;
		return $this;
	}
	
	/**
	 * Get export metadata
	 * 
	 * @return array
	 */
	public function getMetaData()
	{
		return $this->_metaData;
	}
	
	/**
	 * Set export metadata
	 * 
	 * @param array $value
	 * @return MEF_Export
	 */
	public function setMetaData($value = array())
	{
		$this->_metaData = $value;
		return $this;
	}
	
	/**
	 * Get export type
	 * 
	 * @return string
	 */
	public function getExportType()
	{
		return $this->_exportType;
	}
	
	/**
	 * Set export type
	 * 
	 * @param string $value
	 * @return MEF_Export
	 */
	public function setExportType($value = 'class')
	{
		$this->_exportType = $value;
		return $this;
	}
	
	/**
	 * Get export member
	 * 
	 * @return string
	 */
	public function getExportMember()
	{
		return $this->_exportMember;
	}
	
	/**
	 * Set export member
	 * 
	 * @param string $value
	 * @return MEF_Export
	 */
	public function setExportMember($value = null)
	{
		$this->_exportMember = $value;
		return $this;
	}
}
