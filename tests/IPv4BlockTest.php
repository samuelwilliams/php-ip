<?php

class IPv4BlockTest extends PHPUnit_Framework_TestCase
{
	// see http://www.miniwebtool.com/ip-address-to-binary-converter/
	// and http://www.miniwebtool.com/ip-address-to-hex-converter
	public function validBlocks()
	{
		return array(
			//     CIDR            Mask               Delta              First IP          Last IP
			array('0.0.0.0/0',    '0.0.0.0',         '255.255.255.255', '0.0.0.0',        '255.255.255.255'),
			array('130.0.0.0/1',  '128.0.0.0',       '127.255.255.255', '128.0.0.0',      '255.255.255.255'),
			array('130.0.0.0/2',  '192.0.0.0',       '63.255.255.255',  '128.0.0.0',      '191.255.255.255'),
			array('130.0.0.0/3',  '224.0.0.0',       '31.255.255.255',  '128.0.0.0',      '159.255.255.255'),
			array('130.0.0.0/4',  '240.0.0.0',       '15.255.255.255',  '128.0.0.0',      '143.255.255.255'),
			array('130.0.0.0/5',  '248.0.0.0',       '7.255.255.255',   '128.0.0.0',      '135.255.255.255'),
			array('130.0.0.0/6',  '252.0.0.0',       '3.255.255.255',   '128.0.0.0',      '131.255.255.255'),
			array('128.0.1.0/7',  '254.0.0.0',       '1.255.255.255',   '128.0.0.0',      '129.255.255.255'),
			array('127.0.0.0/8',  '255.0.0.0',       '0.255.255.255',   '127.0.0.0',      '127.255.255.255'),
			array('127.0.0.0/9',  '255.128.0.0',     '0.127.255.255',   '127.0.0.0',      '127.127.255.255'),
			array('127.0.0.0/10', '255.192.0.0',     '0.63.255.255',    '127.0.0.0',      '127.63.255.255'),
			array('127.0.0.0/11', '255.224.0.0',     '0.31.255.255',    '127.0.0.0',      '127.31.255.255'),
			array('127.0.0.0/12', '255.240.0.0',     '0.15.255.255',    '127.0.0.0',      '127.15.255.255'),
			array('127.0.0.0/13', '255.248.0.0',     '0.7.255.255',     '127.0.0.0',      '127.7.255.255'),
			array('127.0.0.0/14', '255.252.0.0',     '0.3.255.255',     '127.0.0.0',      '127.3.255.255'),
			array('127.0.0.0/15', '255.254.0.0',     '0.1.255.255',     '127.0.0.0',      '127.1.255.255'),
			array('127.0.0.1/16', '255.255.0.0',     '0.0.255.255',     '127.0.0.0',      '127.0.255.255'),
			array('127.0.0.1/17', '255.255.128.0',   '0.0.127.255',     '127.0.0.0',      '127.0.127.255'),
			array('127.0.0.1/18', '255.255.192.0',   '0.0.63.255',      '127.0.0.0',      '127.0.63.255'),
			array('127.0.0.1/19', '255.255.224.0',   '0.0.31.255',      '127.0.0.0',      '127.0.31.255'),
			array('127.0.0.1/20', '255.255.240.0',   '0.0.15.255',      '127.0.0.0',      '127.0.15.255'),
			array('127.0.0.1/21', '255.255.248.0',   '0.0.7.255',       '127.0.0.0',      '127.0.7.255'),
			array('127.0.0.1/22', '255.255.252.0',   '0.0.3.255',       '127.0.0.0',      '127.0.3.255'),
			array('127.0.0.1/23', '255.255.254.0',   '0.0.1.255',       '127.0.0.0',      '127.0.1.255'),
			array('127.0.0.1/24', '255.255.255.0',   '0.0.0.255',       '127.0.0.0',      '127.0.0.255'),
			array('127.0.0.1/25', '255.255.255.128', '0.0.0.127',       '127.0.0.0',      '127.0.0.127'),
			array('127.0.0.1/26', '255.255.255.192', '0.0.0.63',        '127.0.0.0',      '127.0.0.63'),
			array('127.0.0.1/27', '255.255.255.224', '0.0.0.31',        '127.0.0.0',      '127.0.0.31'),
			array('127.0.0.1/28', '255.255.255.240', '0.0.0.15',        '127.0.0.0',      '127.0.0.15'),
			array('127.0.0.1/29', '255.255.255.248', '0.0.0.7',         '127.0.0.0',      '127.0.0.7'),
			array('127.0.0.1/30', '255.255.255.252', '0.0.0.3',         '127.0.0.0',      '127.0.0.3'),
			array('127.0.0.1/31', '255.255.255.254', '0.0.0.1',         '127.0.0.0',      '127.0.0.1'),
			array('127.0.0.1/32', '255.255.255.255', '0.0.0.0',         '127.0.0.1',      '127.0.0.1'),
		);
	}

	/**
	 * @dataProvider validBlocks
	 */
	public function testConstructValid($block, $mask, $delta, $first_ip, $last_ip)
	{
		$instance = new IPv4Block($block);
		$this->assertEquals($mask, (string) $instance->getMask(), "Mask of $block");
		$this->assertEquals($delta, (string) $instance->getDelta(), "Delta of $block");
		$this->assertEquals($first_ip, (string) $instance->getFirstIp(), "First IP of $block");
		$this->assertEquals($last_ip, (string) $instance->getLastIp(), "Last IP of $block");
	}


	public function invalidBlocks()
	{
		return array(
			array('127.0.2666.1/24'),
			array('127.0.0.1/45'),
			array("\t"),
			array("abc"),
			array(12.3),
			array(-12.3),
			array('-1'),
			array('4294967296'),
			array('2a01:8200::'),
			array('::1')
		);
	}

	/**
	 * @dataProvider invalidBlocks
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructInvalid($block)
	{
		$instance = new IPv4Block($block);
	}

	public function blockContent()
	{
		return array(
			array(
				'192.168.0.0/24',
				array('192.168.0.0','192.168.0.42','192.168.0.255', '192.168.0.128/25'),
				array('10.0.0.1','192.167.255.255','192.169.0.0', '10.0.0.1/24'),
			)
		);
	}

	/**
	 * @dataProvider blockContent
	 */
	public function testContains($block, $in, $not_in)
	{
		$block = new IPv4Block($block);
		foreach ( $in as $ip_or_block ) {
			$this->assertTrue($block->contains($ip_or_block), "$ip_or_block is in $block");
		}
		foreach ( $not_in as $ip_or_block ) {
			$this->assertFalse($block->contains($ip_or_block, "$ip_or_block is not in $block"));
		}
	}


	public function overlappingBlocks()
	{
		return array(
			array(
				'192.168.0.0/24',
				array('192.168.0.128/25', '192.168.0.0/23'),
				array('10.0.0.1/24'),
			)
		);
	}

	/**
	 * @dataProvider overlappingBlocks
	 */
	public function testOverlaps($block, $overlapping, $not_overlapping)
	{
		$block = new IPv4Block($block);
		foreach ( $overlapping as $block2 ) {
			$this->assertTrue($block->overlaps($block2), "$block is overlapping $block2");
			$block2 = new IPv4Block($block2);
			$this->assertTrue($block2->overlaps($block), "$block2 is overlapping $block");
		}
		foreach ( $not_overlapping as $block2 ) {
			$this->assertFalse($block->overlaps($block2, "$block is not overlapping $block2"));
			$block2 = new IPv4Block($block2);
			$this->assertFalse($block2->overlaps($block), "$block2 is not overlappping $block");
		}
	}
}