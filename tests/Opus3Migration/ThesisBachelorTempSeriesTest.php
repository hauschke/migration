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

class Opus3Migration_ThesisBachelorTempSeriesTest extends MigrationTestCase {


    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("ThesisBachelorTempSeries.xml");
    }

    public function setUp() {
        parent::setUp();
    }

    public function testNumberOfDocuments() {
        $odf = new Opus_DocumentFinder();
        $this->assertEquals($odf->count(), '0');
    }

    public function testLicenceInXmlOutput() {
        $this->assertOutputContainsString('<Licence Id="12" Active="1" CommentInternal=');
    }

    public function testThesisPublisherInXmlOutput() {
        $this->assertOutputContainsString('<ThesisPublisher Id="1" Name="Universit&auml;t XYZ" Address="Musterstr. 1, 12345 Musterstadt" City="Ort" DnbContactId="F6000-XXXX" IsGrantor="1" IsPublisher="1"></ThesisPublisher>');
    }

    public function testCollectionInXmlOutput() {
        $this->assertOutputContainsString('<Collection Id="112" Number="000" Name="Informatik, Informationswissenschaft, allgemeine Werke" OaiSubset="000" SortOrder="0" RoleId="2" RoleName="ddc" RoleDisplayFrontdoor="Number, Name" RoleVisibleFrontdoor="true" Visible="1" Theme="opus4"></Collection>');
        $this->assertOutputContainsString('<Collection Id="16205" Name="middle1" SortOrder="0" RoleId="17" RoleName="collections" RoleDisplayFrontdoor="Name" RoleVisibleFrontdoor="true" Visible="1" Theme="opus4"></Collection>');
        $this->assertOutputContainsString('<Collection Id="16214" Name="Institut 2" SortOrder="0" RoleId="1" RoleName="institutes" RoleDisplayFrontdoor="Name" RoleVisibleFrontdoor="true" Visible="1" Theme="opus4"></Collection>');
    }

    public function testSeriesInXmlOutput() {
        $this->assertOutputContainsString('<Series Id="4" Title="Zus&auml;tzliche Schriftenreihe" Visible="1" SortOrder="4" Number="111"></Series>');
        $this->assertOutputContainsString('<Series Id="4" Title="Zus&auml;tzliche Schriftenreihe" Visible="1" SortOrder="4" Number="110"></Series>');
    }


  
}

