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

class Opus3Migration_ArticleMandatoryFieldsTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("ArticleMandatoryFields.xml");
    }
    
    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeArticle() {
        $this->assertEquals($this->doc->getType(), 'article');
    }
    
    public function testTitleMainGerman() {
        $this->assertEquals($this->doc->getTitleMain(0)->getValue(), 'Testaufsatz');
        $this->assertEquals($this->doc->getTitleMain(0)->getLanguage(), 'deu');        
    }
    
    public function testTitleAbstractGerman() {
        $this->assertEquals($this->doc->getTitleAbstract(0)->getValue(), 'Testaufsatz mit 1 Autor und 1 Institut');
        $this->assertEquals($this->doc->getTitleAbstract(0)->getLanguage(), 'deu');
    }

    public function testPersonAuthor() {
        $this->assertEquals($this->doc->getPersonAuthor(0)->getFirstName(), 'John');
        $this->assertEquals($this->doc->getPersonAuthor(0)->getLastName(), 'Doe');
        $this->assertEquals($this->doc->getPersonAuthor(0)->getSortOrder(), '1');
        $this->assertNull($this->doc->getPersonAuthor(0)->getEmail());
    }

    public function testPersonSubmitter() {
        $this->assertEquals(count($this->doc->getPersonSubmitter()), '1');
        $this->assertEquals($this->doc->getPersonSubmitter(0)->getLastName(), 'unknown');
        $this->assertNull($this->doc->getPersonSubmitter(0)->getFirstName());
        $this->assertEquals($this->doc->getPersonSubmitter(0)->getSortOrder(), '1');
        $this->assertEquals($this->doc->getPersonSubmitter(0)->getEmail(), 'foo@test.de');
    }

    public function testCompletedYear() {
        $this->assertEquals($this->doc->getCompletedYear(), '2012');
    }

    public function testCompletedDate() {
        $this->assertStringStartsWith('2012-01-13', $this->doc->getCompletedDate()->__toString());
    }

    public function testServerDatePublished() {
        $this->assertStringStartsWith('2012-01-13', $this->doc->getServerDatePublished()->__toString());
    }

    public function testServerDateCreated() {
        $this->assertStringStartsWith(date("Y-m-d",time()), $this->doc->getServerDateCreated()->__toString());
    }

    public function testServerDateModified() {
        $this->assertStringStartsWith(date("Y-m-d",time()), $this->doc->getServerDateModified()->__toString());
    }

    public function testServerState() {
        $this->assertEquals($this->doc->getServerState(), 'published');
    }

    public function testIdentifierOpus3() {
        $this->assertEquals($this->doc->getIdentifierOpus3(0)->getValue(), '3');
    }

    public function testCollectionDdc() {
        $ddc_collections = Opus_Collection::fetchCollectionsByRoleNumber('2', '000');
        $this->assertTrue($ddc_collections[0]->holdsDocumentById($this->doc->getId()));
    }
 
}
