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

class Opus3Migration_ManualTwoDocumentsEqualFilenameTest extends MigrationTestCase {

    protected $doc1;
    protected $doc2;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::$stepsize = 5;
        parent::migrate("ManualTwoDocumentsEqualFilename.xml");
    }

    public function setUp() {
        parent::setUp();
        $this->doc1 = new Opus_Document(1);
	$this->doc2 = new Opus_Document(2);
    }

    public function testDoctypeManualThesis() {
        $this->assertEquals($this->doc1->getType(), 'report');
	$this->assertEquals($this->doc2->getType(), 'report');
    }

    public function testNumberOfDocuments() {
        $odf = new Opus_DocumentFinder();
        $this->assertEquals($odf->count(), '2');
    }

    public function testFileCount() {
        $this->assertEquals('1', count($this->doc1->getFile()));
        $this->assertEquals('2', count($this->doc2->getFile()));
    }

    public function testLanguage() {
        $this->assertEquals('deu', $this->doc1->getFile(0)->getLanguage());
        $this->assertEquals('deu', $this->doc2->getFile(0)->getLanguage());
        $this->assertEquals('deu', $this->doc2->getFile(1)->getLanguage());
    }

    public function testPathNameFile() {
        $this->assertEquals('lorem_ipsum.pdf', $this->doc1->getFile(0)->getPathName());
        $this->assertEquals('foo_bar.pdf', $this->doc2->getFile(0)->getPathName());
        $this->assertEquals('lorem_ipsum.pdf', $this->doc2->getFile(1)->getPathName());
    }

    public function testErrorOutput() {
        $this->assertOutputNotContainsString("File 'pdf/lorem_ipsum.pdf' already imported");
        $this->assertOutputNotContainsString("File 'foo/foo_bar.pdf' already imported");
        $this->assertOutputContainsString("File 'pdf/foo_bar.pdf' already imported");
    }

    public function testFileLabelWithEqualExtension() {
        $this->assertEquals('Dokument_1.pdf', $this->doc1->getFile(0)->getLabel());
        $this->assertEquals('Dokument_1.pdf', $this->doc2->getFile(0)->getLabel());
        $this->assertEquals('Dokument_2.pdf', $this->doc2->getFile(1)->getLabel());
    }

}
?>
