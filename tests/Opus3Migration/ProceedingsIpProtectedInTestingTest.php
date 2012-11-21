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

class Opus3Migration_ProceedingsIpProtectedInTestingTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("ProceedingsIpProtected.xml", true);
    }


    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeConferenceObject() {
        $this->assertEquals($this->doc->getType(), 'conferenceobject');
    }

    public function testFileCount() {
        $this->assertEquals(count($this->doc->getFile()), '1');
    }

    public function testFilename() {
        $this->assertEquals($this->doc->getFile(0)->getPathName(), 'IP_geschuetzte_Praesentation.pdf');
        $this->assertEquals($this->doc->getFile(0)->getLabel(), 'Dokument_1.pdf');
    }

    public function testVisibility() {
        $this->assertEquals($this->doc->getFile(0)->getVisibleInOai(), '0');
        $this->assertEquals($this->doc->getFile(0)->getVisibleInFrontdoor(), '1');
    }


    public function testUserRoles() {
        $this->assertNotNull(Opus_UserRole::fetchByName('guest'));
        $this->assertOutputContainsString("Role in DB found: guest");
        $this->assertNotNull(Opus_UserRole::fetchByName('campus'));
        $this->assertOutputContainsString("Role imported: campus");
    }


    public function testIprange() {
        $ip_range = new Opus_Iprange(1);
        $this->assertEquals('IP-Range Campus I', $ip_range->getName());
        $this->assertEquals('campus', $ip_range->getRole(0)->getName());
        $this->assertEquals('12.34.56.78', $ip_range->getStartingip());
        $this->assertEquals('12.34.56.90', $ip_range->getEndingip());
    }

    public function testIp() {
        $ip_range = new Opus_Iprange(2);
        $this->assertEquals('IP Campus II', $ip_range->getName());
        $this->assertEquals('campus', $ip_range->getRole(0)->getName());
        $this->assertEquals('12.34.56.79', $ip_range->getStartingip());
        $this->assertEquals('12.34.56.79', $ip_range->getEndingip());
    }


    public function testFileAccess() {
        $guest = Opus_UserRole::fetchByName('guest');
        $this->assertNotContains($this->doc->getFile(0)->getId(), $guest->listAccessFiles());

        $campus = Opus_UserRole::fetchByName('campus');
        $this->assertContains($this->doc->getFile(0)->getId(), $campus->listAccessFiles());
    }


}

