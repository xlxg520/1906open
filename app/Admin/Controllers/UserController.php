<?php

namespace App\Admin\Controllers;
use App\Model\UserModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserModel());

        $grid->column('id', __('Id'));
        $grid->column('u_name', __('用户名'));
        $grid->column('u_email', __('邮箱'));
        //$grid->column('pass', __('Pass'));
        $grid->column('u_number', __('电话'));
        $grid->column('created_at', __('添加时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(UserModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('u_name', __('U name'));
        $show->field('u_email', __('U email'));
        $show->field('pass', __('Pass'));
        $show->field('u_number', __('U number'));
        $show->field('created_at', __('Created at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserModel());

        $form->text('u_name', __('U name'));
        $form->text('u_email', __('U email'));
        $form->text('pass', __('Pass'));
        $form->text('u_number', __('U number'));

        return $form;
    }
}
