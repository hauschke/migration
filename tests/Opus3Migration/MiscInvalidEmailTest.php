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

class Opus3Migration_MiscInvalidEmailTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("MiscInvalidEmail.xml");
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeOther() {
        $this->assertEquals($this->doc->getType(), 'other');
    }

    public function testPersonSubmitter() {
        $this->assertEquals(count($this->doc->getPersonSubmitter()), '1');
        $this->assertEquals($this->doc->getPersonSubmitter(0)->getLastName(), 'unknown');
        $this->assertNull($this->doc->getPersonSubmitter(0)->getFirstName());
        $this->assertNull($this->doc->getPersonSubmitter(0)->getEmail());
    }

    public function testEnrichmentInvalidVerification() {
        $this->assertEquals($this->doc->getEnrichment(0)->getKeyName(), 'InvalidVerification');
        $this->assertEquals($this->doc->getEnrichment(0)->getValue(), 'foo@bar.baz, Telefon: (030) 123 45 678');
    }
}