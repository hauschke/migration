<?php
/**
 * This file is part of OPUS. The software OPUS has been originally developed
 * at the University of Stuttgart with funding from the German Research Net,
 * the Federal Department of Higher Education and Research and the Ministry
 * of Science, Research and the Arts of the State of Baden-Wuerttemberg.
 *
 * OPUS 4 is a complete rewrite of the original OPUS software and was developed
 * by the Stuttgart University Library, the Library Service Center
 * Baden-Wuerttemberg, the Cooperative Library Network Berlin-Brandenburg,
 * the Saarland University and State Library, the Saxon State Library -
 * Dresden State and University Library, the Bielefeld University Library and
 * the University Library of Hamburg University of Technology with funding from
 * the German Research Foundation and the European Regional Development Fund.
 *
 * LICENCE
 * OPUS is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the Licence, or any later version.
 * OPUS is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details. You should have received a copy of the GNU General Public License
 * along with OPUS; if not, write to the Free Software Foundation, Inc., 51
 * Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * @category    TODO
 * @author      Gunar Maiwald <maiwald@zib.de>
 * @copyright   Copyright (c) 2008-2012, OPUS 4 development team
 * @license     http://www.gnu.org/licenses/gpl.html General Public License
 * @version     $Id$
 */

class Opus3Migration_ThesisHabilitationManyAdvisorsTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("ThesisHabilitationManyAdvisors.xml");
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeHabilitation() {
        $this->assertEquals('habilitation', $this->doc->getType());
    }
    
    public function testManyAdvisors() {
        $this->assertEquals('Max M.', $this->doc->getPersonAdvisor(0)->getFirstName());
        $this->assertEquals('Mustermann', $this->doc->getPersonAdvisor(0)->getLastName());
	$this->assertNull($this->doc->getPersonAdvisor(0)->getAcademicTitle());
        $this->assertEquals( '1', $this->doc->getPersonAdvisor(0)->getSortOrder());
        $this->assertNull($this->doc->getPersonAdvisor(0)->getEmail());
        
        $this->assertEquals('John', $this->doc->getPersonAdvisor(1)->getFirstName());
        $this->assertEquals('Doe', $this->doc->getPersonAdvisor(1)->getLastName());
	$this->assertEquals('Ph.D.', $this->doc->getPersonAdvisor(1)->getAcademicTitle());
        $this->assertEquals( '2', $this->doc->getPersonAdvisor(1)->getSortOrder());
        $this->assertNull($this->doc->getPersonAdvisor(1)->getEmail());
        
        $this->assertEquals('Jane', $this->doc->getPersonAdvisor(2)->getFirstName());
        $this->assertEquals('Doe', $this->doc->getPersonAdvisor(2)->getLastName());
	$this->assertEquals('Ph.D.', $this->doc->getPersonAdvisor(2)->getAcademicTitle());
        $this->assertEquals( '3', $this->doc->getPersonAdvisor(2)->getSortOrder());
        $this->assertNull($this->doc->getPersonAdvisor(2)->getEmail());

    }    

}
