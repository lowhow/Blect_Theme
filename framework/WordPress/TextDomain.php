<?php namespace Framework\WordPress;

class TextDomain {
	/**
	 * Load theme text domain.
	 * @return Helper
	 */
	public function load_theme_textdomain()
	{
		load_theme_textdomain( FW_TEXTDOMAIN, FW_THEME_LANG_DIR );

		return $this;
	}
}