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
 * @version     $Id $
 */

class Opus3Migration_ThesisBachelorCollectionsTest extends MigrationTestCase {


    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("ThesisBachelorCollections.xml");
    }


    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
        $this->role_id = Opus_CollectionRole::fetchByName('collections')->getId();
    }

    public function testDoctypeBachelorthesis() {
        $this->assertEquals($this->doc->getType(), 'bachelorthesis');
    }

    public function testNumberCollections() {
        $this->assertEquals(8, count(Opus_Collection::fetchCollectionsByRoleId($this->role_id)));
    }

    public function testCollectionsHierarchy() {
        $root = Opus_CollectionRole::fetchByName('collections')->getRootCollection();

        $top = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'top');
        $this->assertEquals($root->getId(), $top[0]->getParentNodeId());

        $middle1 = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'middle1');
        $this->assertEquals($top[0]->getId(), $middle1[0]->getParentNodeId());
        $middle2 = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'middle2');
        $this->assertEquals($top[0]->getId(), $middle2[0]->getParentNodeId());
        $middle3 = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'middle3');
        $this->assertEquals($top[0]->getId(), $middle3[0]->getParentNodeId());

        $bottom1 = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'bottom1');
        $this->assertEquals($middle2[0]->getId(), $bottom1[0]->getParentNodeId());
        $bottom2 = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'bottom2');
        $this->assertEquals($middle3[0]->getId(), $bottom2[0]->getParentNodeId());
        $bottom3 = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'bottom3');
        $this->assertEquals($middle3[0]->getId(), $bottom3[0]->getParentNodeId());
    }

    public function testCollectionNumber() {
        $top = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'top');
        $this->assertNull($top[0]->getNumber());
    }

    public function testColectionVisible() {
        $top = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'top');
        $this->assertEquals('1', $top[0]->getVisible());
    }

    public function testCollectionOAISubset() {
        $top = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'top');
        $this->assertNull($top[0]->getOaiSubset());
    }

    public function testCollectionTheme() {
        $top = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'top');
        $this->assertNull($top[0]->getTheme());
    }

    public function testCollectionHoldsDocument() {
        $bottom1 = Opus_Collection::fetchCollectionsByRoleName($this->role_id, 'bottom1');
        $this->assertEquals(1, count($bottom1[0]->getDocumentIds()));
    }

    public function testDocumentIsHeldByCollection() {
        /* Document is held by 2 Collections:
         * - DDC 620
         * - bottom1
         */
        $this->assertEquals(2, count($this->doc->getCollection()));
    }
}

