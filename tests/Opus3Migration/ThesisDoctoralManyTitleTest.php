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

/**
 * Description:
 * - Dokumenttyp: Dissertation
 * - Sprache: deutsch
 * - Originaltitel der Arbeit
 * - Titel der Arbeit in Englisch
 * - Titel der Arbeit in Deutsch
 * - Kurze Inhaltszusammenfassung in der Originalsprache (deutsch)
 * - Kurze Inhaltszusammenfassung in einer weiteren Sprache (english)
 *
 * @author gunar
 */


class Opus3Migration_ThesisDoctoralManyTitleTest extends MigrationTestCase {

    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("ThesisDoctoralManyTitle.xml");
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
    }

    public function testDoctypeDoctoralThesis() {
        $this->assertEquals($this->doc->getType(), 'doctoralthesis');
    }

    public function testTitleMainGerman() {
        $this->assertEquals($this->doc->getTitleMain(0)->getValue(), 'Testarbeit Diss');
        $this->assertEquals($this->doc->getTitleMain(0)->getLanguage(), 'deu');
    }

    public function testTitleMainEnglish() {
        $this->assertEquals($this->doc->getTitleMain(1)->getValue(), 'Workingtitle in english');
        $this->assertEquals($this->doc->getTitleMain(1)->getLanguage(), 'eng');
    }

    public function testTitleAbstractGerman() {
        $this->assertEquals($this->doc->getTitleAbstract(0)->getValue(), 'Inhalt deutsch');
        $this->assertEquals($this->doc->getTitleAbstract(0)->getLanguage(), 'deu');
    }

    public function testTitleAbstractEnglish() {
        $this->assertEquals($this->doc->getTitleAbstract(1)->getValue(), 'Inhalt englisch');
        $this->assertEquals($this->doc->getTitleAbstract(1)->getLanguage(), 'eng');
    }

    public function testTitleAdditionalGerman() {
        $this->assertEquals($this->doc->getTitleAdditional(0)->getValue(), 'Titel der Arbeit in Deutsch');
        $this->assertEquals($this->doc->getTitleAdditional(0)->getLanguage(), 'deu');
    }


}