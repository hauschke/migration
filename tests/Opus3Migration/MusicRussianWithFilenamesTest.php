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

class Opus3Migration_MusicRussianWithFilenamesTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        $filename = parent::$fulltext_dir . "2012/19/pdf/Präsentation2.pdf";
        $file = iconv("UTF-8", "ISO-8859-1", $filename);
        $handle = fopen($file, 'w') or die("can't open file");
        fclose($handle);
        parent::migrate("MusicRussianWithFilenames.xml");
        unlink($file);
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeBook() {
        $this->assertEquals('sound', $this->doc->getType());
    }

    public function testTitleMainRussian() {
        $this->assertEquals('Russkaja Musika', $this->doc->getTitleMain(0)->getValue());
        $this->assertEquals('rus', $this->doc->getTitleMain(0)->getLanguage());
    }

    public function testTitleAbstractRussian() {
        $this->assertEquals('Eta russkaja musika!', $this->doc->getTitleAbstract(0)->getValue());
        $this->assertEquals('rus', $this->doc->getTitleAbstract(0)->getLanguage());
    }

    public function testFileCount() {
        $this->assertEquals('3', count($this->doc->getFile()));
    }

    public function testFilenameWithWhitespace() {
        $this->assertEquals('Praesentation Whitespace.pdf', $this->doc->getFile(0)->getPathName());
        $this->assertEquals('Dokument_1.pdf', $this->doc->getFile(0)->getLabel());
    }
  
    public function testFilenameWithSpecialCharacter() {
        $this->assertEquals('Präsentation.pdf', $this->doc->getFile(1)->getPathName());
        $this->assertEquals('Dokument_2.pdf', $this->doc->getFile(1)->getLabel());
    }

    public function testFilenameWithCorruptCharacter() {
        $this->assertEquals('Präsentation2.pdf', $this->doc->getFile(2)->getPathName());
        $this->assertEquals('Dokument_3.pdf', $this->doc->getFile(2)->getLabel());
    }

    public function testVisibility() {
        $this->assertEquals('1', $this->doc->getFile(0)->getVisibleInFrontdoor());
        $this->assertEquals('1', $this->doc->getFile(0)->getVisibleInOai());
        $this->assertEquals('1', $this->doc->getFile(1)->getVisibleInFrontdoor());
        $this->assertEquals('1', $this->doc->getFile(1)->getVisibleInOai());
        $this->assertEquals('1', $this->doc->getFile(2)->getVisibleInFrontdoor());
        $this->assertEquals('1', $this->doc->getFile(2)->getVisibleInOai());
    }


}

