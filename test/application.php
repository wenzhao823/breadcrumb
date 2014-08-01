<?php
class ApplicationController
{
	/**
	 * 主面板
	 */
	public function dashboardAction()
	{
		echo "dashboard";
	}

	/**
	 * 用户列表
	 *
	 * @ParentNav Application/dashboard
	 */
	public function listAction()
	{
		echo 'list page';
	}

	/**
	 * 编辑
	 *
	 * @ParentNav Application/list
	 */
	public function editAction()
	{
		echo 'edit page';
	}
}