# QuickShow 快捷查看功能

## 概述

QuickShow 功能允许在弹窗（Dialog/Modal）中快速查看数据详情，而不需要跳转到单独的详情页面。

## 使用方法

### 1. 启用快捷查看按钮

在 Grid 控制器中启用快捷查看按钮：

```php
use Dcat\Admin\Grid;

public function grid()
{
    return Grid::make(new Model(), function (Grid $grid) {
        // 启用快捷查看按钮
        $grid->showQuickShowButton();
        
        $grid->column('id');
        $grid->column('name');
        $grid->column('email');
    });
}
```

### 2. 配置弹窗尺寸

可以自定义弹窗的宽度和高度：

```php
public function grid()
{
    return Grid::make(new Model(), function (Grid $grid) {
        $grid->showQuickShowButton();
        
        // 设置快捷查看弹窗的尺寸（宽 x 高）
        $grid->option('dialog_show_area', ['800px', '600px']);
        
        $grid->column('id');
        $grid->column('name');
    });
}
```

### 3. 配置全局默认启用

在 `config/admin.php` 配置文件中：

```php
'grid' => [
    'quick_show_button' => true,
    'dialog_show_area' => ['700px', '670px'],
],
```

### 4. 快捷查看与普通查看共存

可以同时显示快捷查看按钮和普通查看按钮：

```php
$grid->showQuickShowButton();  // 弹窗查看
$grid->showViewButton();       // 跳转查看
```

### 5. 只显示快捷查看，隐藏普通查看

```php
$grid->showQuickShowButton();
$grid->disableViewButton();
```

## API 方法

### Grid 方法

- `showQuickShowButton(bool $val = true)`: 显示快捷查看按钮
- `disableQuickShowButton(bool $disable = true)`: 禁用快捷查看按钮

### Show 方法

- `Show::dialog(?string $title = null)`: 创建快捷查看弹窗实例

## 配置选项

### dialog_show_area

设置快捷查看弹窗的默认尺寸：

```php
$grid->option('dialog_show_area', ['700px', '670px']);
// 或在 config/admin.php 中配置
'grid' => [
    'dialog_show_area' => ['700px', '670px'],
],
```

## 注意事项

1. 快捷查看功能使用 layer.js 弹窗组件
2. 弹窗内容通过 AJAX 异步加载
3. 支持在详情页面中使用 `$show->inDialog()` 判断是否在弹窗中
4. 可以使用 `$show->disableHeader()` 和 `$show->disableFooter()` 隐藏详情页的头部和底部

## 示例

```php
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class UserController
{
    public function index(Content $content)
    {
        return $content
            ->title('用户列表')
            ->body($this->grid());
    }
    
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->showQuickShowButton();
            $grid->option('dialog_show_area', ['800px', '600px']);
            
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('email');
            $grid->column('created_at');
        });
    }
    
    public function show($id, Content $content)
    {
        return $content
            ->title('用户详情')
            ->body($this->detail($id));
    }
    
    protected function detail($id)
    {
        return Show::make($id, new User(), function (Show $show) {
            // 在弹窗中时隐藏头部
            $show->inDialog(function ($show) {
                $show->disableHeader();
            });
            
            $show->field('id');
            $show->field('name');
            $show->field('email');
            $show->field('created_at');
        });
    }
}
```
