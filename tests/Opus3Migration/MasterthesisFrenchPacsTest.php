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

class Opus3Migration_MasterthesisFrenchPacsTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("MasterthesisFrenchPacs.xml");
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeMasterThesis() {
        $this->assertEquals($this->doc->getType(), 'masterthesis');
    }

    public function testTitleMainFrench() {
        $this->assertEquals($this->doc->getTitleMain(0)->getValue(), 'Entendez-vous dans les montagnes');
        $this->assertEquals($this->doc->getTitleMain(0)->getLanguage(), 'fra');
    }

    public function testTitleAbstractFrench() {
        $this->assertEquals($this->doc->getTitleAbstract(0)->getValue(), 'Examen de la montagne');
        $this->assertEquals($this->doc->getTitleAbstract(0)->getLanguage(), 'fra');
    }

    public function testCollectionPacs() {
        $pacs_collections = Opus_Collection::fetchCollectionsByRoleNumber('4', '82.56.-b');
        $this->assertTrue($pacs_collections[0]->holdsDocumentById($this->doc->getId()));

        $pacs_collections = Opus_Collection::fetchCollectionsByRoleNumber('4', '84.60.-h');
        $this->assertTrue($pacs_collections[0]->holdsDocumentById($this->doc->getId()));

        $pacs_collections = Opus_Collection::fetchCollectionsByRoleNumber('4', '78.20.-e');
        $this->assertTrue($pacs_collections[0]->holdsDocumentById($this->doc->getId()));

        $pacs_collections = Opus_Collection::fetchCollectionsByRoleNumber('4', '42.70.-a');
        $this->assertTrue($pacs_collections[0]->holdsDocumentById($this->doc->getId()));
    }

}

