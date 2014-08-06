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

class Opus3Migration_MiscFilesWithCommentsAndHierarchyTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("MiscFilesWithCommentsAndHierarchy.xml");
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDocumentLanguage() {
        $this->assertEquals('deu', $this->doc->getLanguage());
    }

    public function testFileCount() {
        $this->assertEquals('5', count($this->doc->getFile()));
    }

    public function testLanguage() {
        $this->assertEquals('deu', $this->doc->getFile(0)->getLanguage());
        $this->assertEquals('deu', $this->doc->getFile(1)->getLanguage());
        $this->assertEquals('deu', $this->doc->getFile(2)->getLanguage());
        $this->assertEquals('deu', $this->doc->getFile(3)->getLanguage());
        $this->assertEquals('deu', $this->doc->getFile(4)->getLanguage());
    }

    public function testFileSize() {
        $this->assertEquals('704', $this->doc->getFile(0)->getFileSize());
        $this->assertEquals('8817', $this->doc->getFile(1)->getFileSize());
        $this->assertEquals('8817', $this->doc->getFile(2)->getFileSize());
        $this->assertEquals('8817', $this->doc->getFile(3)->getFileSize());
        $this->assertEquals('12212', $this->doc->getFile(4)->getFileSize());
    }

    public function testMimeTypeHtml() {
        $this->assertEquals('text/html', $this->doc->getFile(0)->getMimeType());
    }

    public function testMimeTypePdf() {
        $this->assertEquals('application/pdf', $this->doc->getFile(1)->getMimeType());
        $this->assertEquals('application/pdf', $this->doc->getFile(2)->getMimeType());
        $this->assertEquals('application/pdf', $this->doc->getFile(3)->getMimeType());
    }

    public function testMimeTypePs() {
        $this->assertEquals('application/postscript', $this->doc->getFile(4)->getMimeType());
    }


    public function testPathNameOrdinaryFiles() {
        $this->assertEquals('lorem_ipsum.html', $this->doc->getFile(0)->getPathName());
        $this->assertEquals('lorem_ipsum.pdf', $this->doc->getFile(3)->getPathName());
        $this->assertEquals('lorem_ipsum.ps', $this->doc->getFile(4)->getPathName());
    }

    public function testPathNamePlainOriginalFile() {
        $this->assertEquals('original_lorem_ipsum.pdf', $this->doc->getFile(2)->getPathName());
    }

    public function testPathNamOriginalFileInSubDir() {
        $this->assertEquals('original_foo_lorem_ipsum.pdf', $this->doc->getFile(1)->getPathName());
    }

    /**
     * Changed according to OPUSVIER-3342.
     */
    public function testLabelOrdinaryFiles() {
        $this->assertEquals('', $this->doc->getFile(0)->getLabel());
        $this->assertEquals('Dokument_1.pdf', $this->doc->getFile(3)->getLabel());
        $this->assertEquals('Dokument_1.ps', $this->doc->getFile(4)->getLabel());
    }

    public function testLabelOriginalFiles() {
        $this->assertEquals('', $this->doc->getFile(1)->getLabel());
        $this->assertEquals('', $this->doc->getFile(2)->getLabel());
     }

    public function testCommentOrdinaryFiles() {
        $this->assertEquals('bemerkung zum html', $this->doc->getFile(0)->getComment());
        $this->assertEquals('bemerkung zum pdf', $this->doc->getFile(3)->getComment());
        $this->assertEquals('bemerkung zum ps', $this->doc->getFile(4)->getComment());
    }

    /* OPUSVIER-1518 */
    public function testVisibleInFrontdoorOrdinaryFiles() {
        $this->assertEquals('1', $this->doc->getFile(3)->getVisibleInFrontdoor());
        $this->assertEquals('1', $this->doc->getFile(4)->getVisibleInFrontdoor());
    }

    /**
     * Changed according to OPUSVIER-3342.
     */
    public function testNotVisibleInFrontdoorOriginalFiles() {
        $this->assertEquals('0', $this->doc->getFile(0)->getVisibleInFrontdoor());
        $this->assertEquals('0', $this->doc->getFile(1)->getVisibleInFrontdoor());
        $this->assertEquals('0', $this->doc->getFile(2)->getVisibleInFrontdoor());
    }

    /**
     * Changed according to OPUSVIER-3223, confirms fix
     * Changed again, see OPUSVIER-3342.
     */
    public function testVisibleInOaiNonProtectedFiles() {
        $this->assertEquals('0', $this->doc->getFile(0)->getVisibleInOai());
        
        /* files from folder "original" should not be visible in OAI, see OPUSVIER-3223 */
        $this->assertEquals('0', $this->doc->getFile(1)->getVisibleInOai());
        $this->assertEquals('0', $this->doc->getFile(2)->getVisibleInOai());
        
        $this->assertEquals('1', $this->doc->getFile(3)->getVisibleInOai());
        $this->assertEquals('1', $this->doc->getFile(4)->getVisibleInOai());
    }

    /**
     * Changed according to OPUSVIER-3342 and OPUSVIER-3349.
     */
    public function testFileAccessNonProtectedFiles() {
        $guest = Opus_UserRole::fetchByName('guest');
        $this->assertNotContains($this->doc->getFile(0)->getId(), $guest->listAccessFiles());
        $this->assertNotContains($this->doc->getFile(1)->getId(), $guest->listAccessFiles());
        $this->assertNotContains($this->doc->getFile(2)->getId(), $guest->listAccessFiles());
        $this->assertContains($this->doc->getFile(3)->getId(), $guest->listAccessFiles());
        $this->assertContains($this->doc->getFile(4)->getId(), $guest->listAccessFiles());
    }

}

