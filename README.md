# octobercms Widget 小部件

## 小部件列表
* 自定义图片裁剪插件

### 自定义图片裁剪插件使用场景

> 有这样的一个场景，你要发布一个活动，而活动的封面图需要固定比例大小，而octobercms并没有提供这样的一个插件，而目前遇到了这样的一个需求，实现出来，方便大家。

#### 要求
图片最后是上传到阿里云oss 依赖 [oc-plugin-oss](https://github.com/jc91715/oc-plugin-oss)

#### 如何使用

##### 1 默认不裁剪
```
 image:
    label: 封面图
    type: Jc91715\Widget\FormWidgets\CustomFileUpload
```

##### 2 启用裁剪,宽高比为1
```
 image:
    label: 封面图
    type: Jc91715\Widget\FormWidgets\CustomFileUpload
    ifCrop: 1
    radio: 1    
```
##### 3 页面上多个使用需定义一些额外参数，这些额外参数是为了和其它引入的元素冲突
```
    image1:
        label: 封面图2
        type: Jc91715\Widget\FormWidgets\CustomFileUpload
        ifCrop: 1
        radio: 1
        inputId: custom-input-src2
        inputFileId: file-change2
        imgId: img-src-temp2
        cropId: crop-id2
```
在一个页面上引入多个，这四个参数依次递增即可

```
    inputId: custom-input-src2
    inputFileId: file-change2
    imgId: img-src-temp2
    cropId: crop-id2
```

