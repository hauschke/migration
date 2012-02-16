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

class Opus3Migration_InProceedingsSubjectsTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("InProceedingsSubjects.xml");
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeConferenceObject() {
        $this->assertEquals($this->doc->getType(), 'conferenceobject');
    }

    public function testSubjectsUncontrolledGerman() {
        $this->assertEquals($this->doc->getSubject(0)->getLanguage(), 'deu');
        $this->assertEquals($this->doc->getSubject(0)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(0)->getValue(), 'das');
        $this->assertEquals($this->doc->getSubject(1)->getLanguage(), 'deu');
        $this->assertEquals($this->doc->getSubject(1)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(1)->getValue(), 'sind');
        $this->assertEquals($this->doc->getSubject(2)->getLanguage(), 'deu');
        $this->assertEquals($this->doc->getSubject(2)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(2)->getValue(), 'fünf');
        $this->assertEquals($this->doc->getSubject(3)->getLanguage(), 'deu');
        $this->assertEquals($this->doc->getSubject(3)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(3)->getValue(), 'freie');
        $this->assertEquals($this->doc->getSubject(4)->getLanguage(), 'deu');
        $this->assertEquals($this->doc->getSubject(4)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(4)->getValue(), 'schlagworte');
    }

    public function testSubjectsUncontrolledEnglish() {
        $this->assertEquals($this->doc->getSubject(5)->getLanguage(), 'eng');
        $this->assertEquals($this->doc->getSubject(5)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(5)->getValue(), 'this');
        $this->assertEquals($this->doc->getSubject(6)->getLanguage(), 'eng');
        $this->assertEquals($this->doc->getSubject(6)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(6)->getValue(), 'are');
        $this->assertEquals($this->doc->getSubject(7)->getLanguage(), 'eng');
        $this->assertEquals($this->doc->getSubject(7)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(7)->getValue(), 'five');
        $this->assertEquals($this->doc->getSubject(8)->getLanguage(), 'eng');
        $this->assertEquals($this->doc->getSubject(8)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(8)->getValue(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(9)->getLanguage(), 'eng');
        $this->assertEquals($this->doc->getSubject(9)->getType(), 'uncontrolled');
        $this->assertEquals($this->doc->getSubject(9)->getValue(), 'keywords');
    }

}
