<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;

class CategoryController extends Controller
{
    use ModelForm;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('分类管理');
            $content->body(Category::tree());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        Category::tree(function ($tree) {
            $tree->branch(function ($branch) {
                $src = config('admin.upload.host') . '/' . $branch['logo'] ;
                $logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";

                return "{$branch['id']} - {$branch['title']} $logo";
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Category::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('parent_id','所属分类')->options(function () {
                $merge = [0 => '顶级分类'];
                foreach (Category::get() as $key => $cate) {
                    $merge[$key+1] = $cate->title;
                }
                return $merge;
            });
            $form->text('title','分类名')->placeholder('请输入分类名');
            $form->display('created_at', 'Created At');
            $form->saved(function (Form $form) {
                if(Category::find($form->parent_id))
                    $this->level = Category::where(['id' => $form->parent_id])->first()->level + 1;
                else
                    $this->level = 0;
                return Category::where('id',Category::orderBy('id','DESC')->first()->id)->update(['level' => $this->level]);
            });
        });
    }
}
