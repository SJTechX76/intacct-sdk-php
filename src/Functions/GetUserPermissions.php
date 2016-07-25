<?php

/**
 * Copyright 2016 Intacct Corporation.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 * use this file except in compliance with the License. You may obtain a copy
 * of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Intacct\Functions;

use InvalidArgumentException;
use Intacct\Xml\XMLWriter;

class GetUserPermissions implements FunctionInterface
{
    
    use ControlIdTrait;
    
    /** @var string */
    private $userId;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     *      @var string $control_id Control ID, default=Random UUID
     *      @var string $user_id User ID to get permissions for
     * }
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'control_id' => null,
            'user_id' => null,
        ];
        $config = array_merge($defaults, $params);
        
        if (!$config['user_id']) {
            throw new InvalidArgumentException(
                'Required "user_id" key not supplied in params'
            );
        }
        
        $this->setControlId($config['control_id']);
        $this->userId = $config['user_id'];
    }
    
    /**
     * Write the getUserPermissions block XML
     *
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());
        
        $xml->startElement('getUserPermissions');
        
        $xml->writeElement('userId', $this->userId, true);
        
        $xml->endElement(); //getUserPermissions
        
        $xml->endElement(); //function
    }
}
