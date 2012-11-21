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

class Opus3Migration_InProceedingsSubjectsEnrichmentsInTestingTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("InProceedingsSubjects.xml", true);
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeConferenceObject() {
        $this->assertEquals($this->doc->getType(), 'conferenceobject');
    }

   /* Test for OPUSVIER-2544 */
    public function testSubjectsSwdAsSubjects() {
        $this->assertEquals('deu', $this->doc->getSubject(0)->getLanguage());
        $this->assertEquals('swd', $this->doc->getSubject(0)->getType());
        $this->assertEquals('Unsicherheit', $this->doc->getSubject(0)->getValue());
        $this->assertEquals('deu', $this->doc->getSubject(1)->getLanguage());
        $this->assertEquals('swd', $this->doc->getSubject(1)->getType());
        $this->assertEquals('Monsun', $this->doc->getSubject(1)->getValue());
        $this->assertEquals('deu', $this->doc->getSubject(2)->getLanguage());
        $this->assertEquals('swd', $this->doc->getSubject(2)->getType());
        $this->assertEquals('Klimatologie', $this->doc->getSubject(2)->getValue());
    }

    public function testSubjectsUncontrolledGermanAsSubjects() {
        $this->assertEquals('deu', $this->doc->getSubject(3)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(3)->getType());
        $this->assertEquals('das', $this->doc->getSubject(3)->getValue());
        $this->assertEquals('deu',$this->doc->getSubject(4)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(4)->getType());
        $this->assertEquals('sind', $this->doc->getSubject(4)->getValue());
        $this->assertEquals('deu',$this->doc->getSubject(5)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(5)->getType());
        $this->assertEquals('fünf', $this->doc->getSubject(5)->getValue());
        $this->assertEquals('deu',$this->doc->getSubject(6)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(6)->getType());
        $this->assertEquals('freie', $this->doc->getSubject(6)->getValue());
        $this->assertEquals('deu',$this->doc->getSubject(7)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(7)->getType());
        $this->assertEquals('schlagworte', $this->doc->getSubject(7)->getValue());
    }

    public function testSubjectsUncontrolledEnglishAsSubjects() {
        $this->assertEquals('eng', $this->doc->getSubject(8)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(8)->getType());
        $this->assertEquals('this', $this->doc->getSubject(8)->getValue());
        $this->assertEquals('eng', $this->doc->getSubject(9)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(9)->getType());
        $this->assertEquals('are', $this->doc->getSubject(9)->getValue());
        $this->assertEquals('eng', $this->doc->getSubject(10)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(10)->getType());
        $this->assertEquals('five', $this->doc->getSubject(10)->getValue());
        $this->assertEquals('eng', $this->doc->getSubject(11)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(11)->getType());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(11)->getValue());
        $this->assertEquals('eng', $this->doc->getSubject(12)->getLanguage());
        $this->assertEquals('uncontrolled', $this->doc->getSubject(12)->getType());
        $this->assertEquals('keywords', $this->doc->getSubject(12)->getValue());
    }
    
    /* Test for OPUSVIER-2544 */
    public function testSubjectsSwdAsEnrichments() {
        $this->assertEquals('SubjectSwd', $this->doc->getEnrichment(0)->getKeyName());
        $this->assertEquals('Unsicherheit , Monsun , Klimatologie', $this->doc->getEnrichment(0)->getValue());
    }

    /* Test for OPUSVIER-2544 */
    public function testSubjectsUncontrolledGermanAsEnrichments() {
        $this->assertEquals('SubjectUncontrolledGerman', $this->doc->getEnrichment(1)->getKeyName());
        $this->assertEquals('das , sind , fünf , freie , schlagworte', $this->doc->getEnrichment(1)->getValue());
    }

    /* Test for OPUSVIER-2544 */
    public function testSubjectsUncontrolledEnglishAsEnrichments() {
        $this->assertEquals('SubjectUncontrolledEnglish', $this->doc->getEnrichment(2)->getKeyName());
        $this->assertEquals('this , are , five , uncontrolled , keywords', $this->doc->getEnrichment(2)->getValue());
    }

}
