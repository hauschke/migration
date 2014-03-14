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

class Opus3Migration_ThesisBachelorSeriesTwiceTest extends MigrationTestCase {


    protected $doc;

    public static function setUpBeforeClass()  {
        parent::setUpBeforeClass();
        parent::migrate("ThesisBachelorSeriesTwice.xml");
    }

    public function setUp() {
        parent::setUp();
    }

    public function testNumberOfDocuments() {
        $odf = new Opus_DocumentFinder();
        $this->assertEquals($odf->count(), '0');
    }

    public function testLicenceInXmlOutput() {
        $this->assertOutputContainsString('<Licence Id="12" Active="1" CommentInternal="Zus. zu ubt-podok darf hier:&#10;- auch von dritten vervielf&amp;auml;ltigt und verbreitet werden.&#10;Zus&amp;auml;tzlich zu cc_by-nc-nd darf hier ausserdem noch:&#10;- das Werk ver&amp;auml;ndert oder bearbeitet werden&#10;- kommzeriell verwertet werden&#10;&#10;Lediglich die Namensnennung ist zwingend." DescMarkup="&lt;!-- Creative Commons License --&gt;&#10;&#10;&lt;!--&#10;&#10;&lt;rdf:RDF xmlns=&quot;http://web.resource.org/cc/&quot;&#10;    xmlns:dc=&quot;http://purl.org/dc/elements/1.1/&quot;&#10;    xmlns:rdf=&quot;http://www.w3.org/1999/02/22-rdf-syntax-ns#&quot;&gt;&#10;&lt;Work rdf:about=&quot;&quot;&gt;&#10;   &lt;dc:type rdf:resource=&quot;http://purl.org/dc/dcmitype/Text&quot; /&gt;&#10;   &lt;license rdf:resource=&quot;http://creativecommons.org/licenses/by/2.0/de/&quot; /&gt;&#10;&lt;/Work&gt;&#10;&#10;&lt;License rdf:about=&quot;http://creativecommons.org/licenses/by/2.0/de/&quot;&gt;&#10;   &lt;permits rdf:resource=&quot;http://web.resource.org/cc/Reproduction&quot; /&gt;&#10;   &lt;permits rdf:resource=&quot;http://web.resource.org/cc/Distribution&quot; /&gt;&#10;   &lt;requires rdf:resource=&quot;http://web.resource.org/cc/Notice&quot; /&gt;&#10;   &lt;requires rdf:resource=&quot;http://web.resource.org/cc/Attribution&quot; /&gt;&#10;   &lt;permits rdf:resource=&quot;http://web.resource.org/cc/DerivativeWorks&quot; /&gt;&#10;&lt;/License&gt;&#10;&#10;&lt;/rdf:RDF&gt;&#10;&#10;--&gt;&#10;" DescText="Bei dieser Lizenz darf der Inhalt vervielfältigt, verbreitet und öffentlich aufgeführt werden, Bearbeitungen angefertigt und der Inhalt kommerziell genutzt werden unter den folgenden Bedingungen: Der Name des Autors/Rechtsinhabers muss genannt werden.&#10;Dies ist eine Lizenz, die auf der internationalen Creative Commons-Initiative basiert." Language="deu" LinkLicence="http://creativecommons.org/licenses/by/2.0/de/deed.de" LinkLogo="http://creativecommons.org/images/public/somerights20.gif" LinkSign="http://&lt;server&gt;/opus/doku/lizenzen/cc_by.pdf" MimeType="text/html" NameLong="Creative Commons - Namensnennung" SortOrder="16" PodAllowed="1"/>');
    }

    public function testThesisPublisherInXmlOutput() {
        $this->assertOutputContainsString('<ThesisPublisher Id="1" Name="Universität XYZ" Address="Musterstr. 1, 12345 Musterstadt" City="Ort" DnbContactId="F6000-XXXX" IsGrantor="1" IsPublisher="1"/>');
    }

    public function testCollectionInXmlOutput() {
        $this->assertOutputContainsString('<Collection Id="112" Number="000" Name="Informatik, Informationswissenschaft, allgemeine Werke" OaiSubset="000" SortOrder="0" RoleId="2" RoleName="ddc" RoleDisplayFrontdoor="Number, Name" RoleVisibleFrontdoor="true" DisplayFrontdoor="0 Informatik, Informationswissenschaft, allgemeine Werke / 00 Informatik, Wissen, Systeme / 000 Informatik, Informationswissenschaft, allgemeine Werke" Visible="1" Theme="opus4"/>');
        $this->assertOutputContainsString('<Collection Id="16205" Name="middle1" SortOrder="0" RoleId="17" RoleName="collections" RoleDisplayFrontdoor="Name" RoleVisibleFrontdoor="true" DisplayFrontdoor="top / middle1" Visible="1" Theme="opus4"/>');
        $this->assertOutputContainsString('<Collection Id="16214" Name="Institut 2" SortOrder="0" RoleId="1" RoleName="institutes" RoleDisplayFrontdoor="Name" RoleVisibleFrontdoor="true" DisplayFrontdoor="Fakultät Test 2 / Institut 2" Visible="1" Theme="opus4"/>');
    }

    public function testSeriesInXmlOutput() {
        $this->assertOutputContainsString('<Series Id="4" Title="Zusätzliche Schriftenreihe" Visible="1" SortOrder="4" Number="111"/>');
        $this->assertOutputContainsString('<Series Id="4" Title="Zusätzliche Schriftenreihe" Visible="1" SortOrder="4" Number="110"/>');
    }


  
}

