<?php namespace Framework\Core;

class ExtensionLoader implements Subject
{

	protected $observers = array();

	/**
	 * Attach Observers
	 * @param  Observer $observer
	 * @return [type]
	 */
	public function attach( Observer $observer ) 
	{
		$this->observers[] = $observer;

		return $this;
	}


	/**
	 * Detach an Observer
	 * @param  [type] $index
	 * @return [type]
	 */
	public function detach( $index ) 
	{
		unset( $this->observers[ $index ] );
	}


	/**
	 * Notify all observers
	 * @return [type]
	 */
	public function notify() 
	{
		foreach( $this->observers as $observer ) 
		{
			$observer->handle();
		}
	}

	/**
	 * Call notify()
	 * @return [type]
	 */
	public function load()
	{
		$this->notify();
	}

}