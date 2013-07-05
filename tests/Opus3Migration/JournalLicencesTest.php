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

class Opus3Migration_JournalLicencesTest extends MigrationTestCase {


    protected $doc;
    protected $lic;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("JournalLicences.xml");
    }

    public function setUp() {
        parent::setUp();
        $this->doc = new Opus_Document(1);
        $this->lic = new Opus_Licence(9);
        $this->lic2 = new Opus_Licence(10);
        $this->lic3 = new Opus_Licence(11);
        $this->lic4 = new Opus_Licence(12);
    }

    public function testDoctypePeriodical() {
        $this->assertEquals($this->doc->getType(), 'periodical');
    }

    public function testNumberLicencesAfterMigration() {
        $this->assertEquals(10 ,count(Opus_Licence::getAll()));
    }

    public function testLicenceNameLong() {
        $this->assertEquals('Veröffentlichungsvertrag für Publikationen mit Print on Demand', $this->lic->getNameLong());
    }

    public function testLicenceDescText() {
         $this->assertEquals('Der Veröffentlichungsvertrag für Publikationen mit Print on Demand. Damit geben Sie der Universitätsbibliothek XYZ das (nicht-exklusive) Recht, die Arbeit weltweit frei zugänglich im Internet zu veröffentlichen.
Sie bleiben als AutorIn selbstverständlich aber EigentümerIn der Urheberrechte und haben weiterhin das Recht, die Publikation anderweitig zu veröffentlichen, zu verändern oder in sonstiger Weise zu verwerten.
 Sie geben einem Leser die Möglichkeit, mit unserer Vermittlung ein Print-on-Demand-Exemplar herzustellen. Es handelt sich um einen Zusatz-Service ohne kommerzielle Interessen.', $this->lic->getDescText());
    }

    public function testLicenceLinkLicence() {
        $this->assertEquals('http://<server>/opus/doku/lic_mit_pod.php', $this->lic->getLinkLicence());
    }

    public function testLicenceLinkSign() {
        $this->assertEquals('http://<server>/opus/doku/lizenzen/formblatt_pod.pdf', $this->lic->getLinkSign());
    }

    public function testLicenceMimeType() {
        $this->assertEquals('text/html', $this->lic->getMimeType());
    }

    public function testLicenceLinkLogo() {
        $this->assertEquals('http://<server>/opus/Icons/unilogo.gif', $this->lic->getLinkLogo());
    }

    public function testLicenceActive() {
        $this->assertEquals(1, $this->lic->getActive());
        $this->assertEquals(0, $this->lic2->getActive());
    }

    public function testLicencePodAllowed() {
        $this->assertEquals(1, $this->lic->getPodAllowed());
        $this->assertEquals(0, $this->lic2->getPodAllowed());
    }
    
    public function testLicenceLanguage() {
        $this->assertEquals('deu', $this->lic->getLanguage());
        $this->assertEquals('eng', $this->lic2->getLanguage());
    }

    public function testLicenceCommentInternal() {
        $this->assertEquals('http://<server>/opus/doku/lizenzen/formblatt.pdf', $this->lic->getCommentInternal());
    }

    public function testLicenceDescMarkup() {
        $this->assertEquals('<!-- Creative Commons-Lizenzvertrag -->

<!--

<rdf:RDF xmlns="http://web.resource.org/cc/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Work rdf:about="">
   <dc:type rdf:resource="http://purl.org/dc/dcmitype/Text" />
   <license rdf:resource="http://creativecommons.org/licenses/by-nc-nd/2.0/de/" />
</Work>

<License rdf:about="http://creativecommons.org/licenses/by-nc-nd/2.0/de/">
   <permits rdf:resource="http://web.resource.org/cc/Reproduction" />
   <permits rdf:resource="http://web.resource.org/cc/Distribution" />
   <requires rdf:resource="http://web.resource.org/cc/Notice" />
   <requires rdf:resource="http://web.resource.org/cc/Attribution" />
   <prohibits rdf:resource="http://web.resource.org/cc/CommercialUse" />
</License>

</rdf:RDF>

-->', $this->lic3->getDescMarkup());
    }


    public function testLicencesSortOrder() {
        $this->assertEquals(13, $this->lic->getSortOrder());
        $this->assertEquals(14, $this->lic2->getSortOrder());
        $this->assertEquals(15, $this->lic3->getSortOrder());
        $this->assertEquals(16, $this->lic4->getSortOrder());
    }


    public function testLicenceDefaultValues() {
        $this->assertEquals(0, $this->lic4->getActive());
        $this->assertEquals('deu', $this->lic4->getLanguage());
        $this->assertEquals('http://creativecommons.org/licenses/', $this->lic4->getLinkLicence());
        $this->assertEquals('text/html', $this->lic4->getMimeType());
        $this->assertEquals('Lizenzname', $this->lic4->getNameLong());
        $this->assertEquals(0, $this->lic4->getPodAllowed());
    }

}

