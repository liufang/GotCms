<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category Gc_Tests
 * @package  Library
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Gc\Module;

use Gc\Registry;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:09.
 *
 * @group Gc
 * @category Gc_Tests
 * @package  Library
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Model
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->object = Model::fromArray(
            array(
                'name' => 'ModuleTest',
            )
        );
        $this->object->save();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
        $collection = new Collection();
        foreach ($collection->getModules() as $module) {
            $module->delete();
        }
    }

    /**
     * Test
     *
     * @return void
     */
    public function testFromArray()
    {
        $this->assertInstanceOf('Gc\Module\Model', Model::fromArray($this->object->getData()));
    }

    /**
     * Test
     *
     * @return void
     */
    public function testFromId()
    {
        $this->assertInstanceOf('Gc\Module\Model', Model::fromId($this->object->getId()));
    }

    /**
     * Test
     *
     * @return void
     */
    public function testFromWrongId()
    {
        $this->assertFalse(Model::fromId('undefined'));
    }

    /**
     * Test
     *
     * @return void
     */
    public function testFromName()
    {
        $this->assertInstanceOf('Gc\Module\Model', Model::fromName($this->object->getName()));
    }

    /**
     * Test
     *
     * @return void
     */
    public function testFromWrongName()
    {
        $this->assertFalse(Model::fromName('undefined'));
    }

    /**
     * Test
     *
     * @return void
     */
    public function testSave()
    {
        $this->assertInternalType('integer', (int) $this->object->save());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testSaveWithWrongValues()
    {
        $configuration = Registry::get('Application')->getConfig();
        if ($configuration['db']['driver'] == 'pdo_mysql') {
            $this->markTestSkipped('Mysql does not thrown exception.');
        }

        $this->setExpectedException('Gc\Exception');
        $this->object->setName(null);
        $this->assertFalse($this->object->save());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testDelete()
    {
        $this->assertTrue($this->object->delete());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testDeleteWithWrongValues()
    {
        $configuration = Registry::get('Application')->getConfig();
        if ($configuration['db']['driver'] == 'pdo_mysql') {
            $this->markTestSkipped('Mysql does not thrown exception.');
        }

        $this->setExpectedException('\Gc\Exception');
        $model = new Model();
        $model->setId('undefined');
        $this->assertFalse($model->delete());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testDeleteWithNoId()
    {
        $model = new Model();
        $this->assertFalse($model->delete());
    }

    /**
     * Test
     *
     * @return void
     */
    public function testInstallWithInvalidData()
    {
        $this->object->delete();
        $modules = Registry::get('Application')->getServiceManager()->get('CustomModules');
        $this->assertFalse(Model::install($modules, 'Test'));
    }

    /**
     * Test
     *
     * @return void
     */
    public function testUnInstallWithInvalidData()
    {
        $modules = Registry::get('Application')->getServiceManager()->get('CustomModules');
        $this->assertFalse(Model::uninstall($modules->getModule('Test'), Model::fromName('Test')));
    }

    /**
     * Test
     *
     * @return void
     */
    public function testInstallAndUninstall()
    {
        $modules = Registry::get('Application')->getServiceManager()->get('CustomModules');
        Model::uninstall($modules->getModule('Blog'), Model::fromName('Blog'));
        $this->assertInternalType('integer', (int) Model::install($modules, 'Blog'));
        $this->assertTrue(Model::uninstall($modules->getModule('Blog'), Model::fromName('Blog')));
    }
}
