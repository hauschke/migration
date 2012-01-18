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

class Opus3Migration_Testdump7Test extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::migrate("testdump_7.xml");
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeHabilitation() {
        $this->assertEquals($this->doc->getType(), 'habilitation');
    }

    public function testTitleAdditionalGermanFromOpusDiss() {
        $this->assertEquals($this->doc->getTitleAdditional(0)->getValue(), 'Testhabilitation (deu)');
        $this->assertEquals($this->doc->getTitleAdditional(0)->getLanguage(), 'deu');
    }

    public function testInstituteStructure() {
        $root = Opus_CollectionRole::fetchByName('institutes')->getRootCollection();

        $faculty1 = Opus_Collection::fetchCollectionsByRoleName('1', 'Fakultät Test 1');
        $this->assertEquals($faculty1[0]->getParentNodeId(), $root->getId());
        $faculty2 = Opus_Collection::fetchCollectionsByRoleName('1', 'Fakultät Test 2');
        $this->assertEquals($faculty2[0]->getParentNodeId(), $root->getId());

        $institute1 = Opus_Collection::fetchCollectionsByRoleName('1', 'Institut 1');
        $this->assertEquals($institute1[0]->getParentNodeId(), $faculty1[0]->getId());
        $institute2 = Opus_Collection::fetchCollectionsByRoleName('1', 'Institut 2');
        $this->assertEquals($institute2[0]->getParentNodeId(), $faculty2[0]->getId());
    }

    public function testInstituteHoldsDocument() {
        $institute = Opus_Collection::fetchCollectionsByRoleName('1', 'Institut 2');
        $this->assertTrue($institute[0]->holdsDocumentById($this->doc->getId()));
    }

    public function testThesisDateAccepted() {
        $this->assertStringStartsWith('2012-01-02', $this->doc->getThesisDateAccepted()->__toString());
    }

    public function testDnbInstituteUniversity() {
        $dnbinst = new Opus_DnbInstitute(1);
        $this->assertEquals($dnbinst->getName(), 'Universität XYZ');
        $this->assertEquals($dnbinst->getAddress(), 'Musterstr. 1, 12345 Musterstadt');
        $this->assertEquals($dnbinst->getCity(), 'Ort');
        $this->assertEquals($dnbinst->getDnbContactId(), 'F6000-XXXX');
        $this->assertNull($dnbinst->getPhone());
        $this->assertEquals($dnbinst->getIsGrantor(), '1');
        $this->assertEquals($dnbinst->getIsPublisher(), '1');
    }

    public function testDnbInstituteFaculty() {
        $dnbinst = new Opus_DnbInstitute(2);
        $this->assertEquals($dnbinst->getName(), 'Universität XYZ,Fakultät Test 1');
        $this->assertNull($dnbinst->getAddress());
        $this->assertEquals($dnbinst->getCity(), 'Ort');
        $this->assertNull($dnbinst->getDnbContactId());
        $this->assertNull($dnbinst->getPhone());
        $this->assertEquals($dnbinst->getIsGrantor(), '1');
        $this->assertEquals($dnbinst->getIsPublisher(), '0');
    }
    
    public function testThesisPublisher() {
        $this->assertEquals($this->doc->getThesisPublisher(0)->getName(), 'Universität XYZ');
        $this->assertEquals($this->doc->getThesisPublisher(0)->getCity(), 'Ort');
    }
    
    public function testThesisGrantor() {
        $this->assertEquals($this->doc->getThesisGrantor(0)->getName(), 'Universität XYZ,Fakultät Test 2');
        $this->assertEquals($this->doc->getThesisGrantor(0)->getCity(), 'Ort');
    }

}
