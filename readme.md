#本程序为TWT-微北洋上的食堂菜品程序

#本程序采用JWT-AUTH验证逻辑
    ##在向本程序所有进行请求时，需要添加一个Header
        ###Accept:application/vnd.YOUR_SUBTYPE.version+json
            +其中SubType 是 yelp
            +version为版本号 v1
        <!--###2.Authorization:Bearer {Token}-->

#本程序因整合于微北洋中，需要用微北洋token换取本程序的token
    ##(GET /api/token/getToken)
        +Parameters
            * wpy_token = {$wpy_token}
        +Response
            * { 
                "errCode": code,
                "errMsg": "msg", 
                "data": {
                         "token" : ""
                        }
              }
        +errCode
    
    ##(GET /api/token/checkToken)
        +Header
            * Authorization:Bearer {$token}
        +Parameters
            
        +Response
            * {
                "errCode": code, 
                "errMsg": "msg", 
                "data": {}
              }
            
    ##(GET /api/token/refreshToken)
        +Header
            * Authorization:Bearer {$token}
        +Parameters
                    
        +Response
            * {
                 "errCode": code,
                 "errMsg": "msg",
                 "data": {
                           "newtoken": ""
                         }
               }
               
    ##(GET /api/token/getUser)
        +Header
            * Authorization:Bearer {$token}
        +Parameters
                            
        +Response
        * {
         "errCode": code,
         "errMsg": "msg",
         "data": {
                  "user": {
                      "id": "",
                      "twtid": "",
                      "twtuname": "",
                      "realname": "",
                      "studentid": "",
                      "created_at": "",
                      "updated_at": ""
                    }
                  }
          }

#在获得本程序Token之后，访问本程序一下所有的功能都需要加上Header
    ##Header
        * Authorization:Bearer {$token}

#获取所有菜品列表 (GET /api/foods/{$sequence}/all/pagesize/{$pagesize}?page={$page})
    +Parameters
        + {$sequence} :
            > asc  升序
            > desc 降序
        + {$pagesize} :
            > 自定义每页返回数量(>0)  默认为 30 
        + {$page} :
            > 数据的页数
    +Response
        * {
            "errCode": code,
            "errMsg": "msg",
            "data": {
                        {
                            "id" : "",
                            "name" : "",
                            "price" : "",
                            "category_id" : "",
                            "floor" : "",
                            "score" : "",
                        }
                        {
                            "id" : "",
                            "name" : "",
                            "price" : "",
                            "category_id" : "",
                            "floor" : "",
                            "score" : "",
                        }
                     }
           }

#获取某一种类菜品列表(GET /api/foods/{$sequence}/{cid}/all/pagesize/{$pagesize}?page={$page})
    +Parameters
            + {$sequence} :
                * asc  升序
                * desc 降序
            + {$cid} :
                > 北洋园校区
                    * 1 . 梅园/学一     
                    * 2 . 兰园/学二
                    * 3 . 棠园/学三
                    * 4 . 竹园/学四
                    * 5 . 桃园/学五
                    * 6 . 菊园/清真
                    * 7 . 留院
                    * 8 . 青园

                > 卫津路校区
                    * 11 . 学一食堂
                    * 12 . 学二食堂
                    * 13 . 学三食堂
                    * 14 . 学四食堂
                    * 15 . 学五食堂
            + {$pagesize} :
                > 自定义每页返回数量(>0)  默认为 30 
            + {$page} :
                > 数据的页数
    
    +Response:
            * {
                        "errCode": code,
                        "errMsg": "msg",
                        "data": {
                                    {
                                    "id" : "",
                                    "name" : "",
                                    "price" : "",
                                    "category_id" : "",
                                    "floor" : "",
                                    "score" : "",
                                    }                         
                                    {
                                    "id" : "",
                                    "name" : "",
                                    "price" : "",
                                    "category_id" : "",
                                    "floor" : "",
                                    "score" : "",
                                     }
                                }
              }
# 获取菜品的信息(GET /api/food/{food_id})
    +Parameters
        * {$food_id}
    +Response:
        *{
            "errCode": code,
            "errMsg": "msg",
            "data": {
                        "id" : "",
                        "name" : "",
                        "price" : "",
                        "category_id" : "",
                        "floor" : "",
                        "score" : "",
                    }
         }

# 添加菜品信息(POST /api/food/addFood)
    +Parameters :
        * {$name} : 菜品名称
        * {$price} : 菜品价格
        * {$category_id} : 食堂代号id
        * {$floor} : 楼层
        * {$score} : 评分
        * {$imgs} : 上传的照片
    +Response :
        * {
                "errCode" : code,
                "errMsg" : "msg",
                "data" : {
                            "id" : "",
                            "imgurls" : {
                                            {"id" : "", "imgurl" : ""}
                                            {"id" : "", "imgurl" : ""}
                                        }
                         }
           }


# 添加喜欢信息(POST /api/comment/{$comment_id}/addLike)
    + Parameters : 
        {$comment_id} : 评论的id
    + Response :
        {
            "errCode" : code,
            "errMsg" : "msg",
            "data" : {
                        "id" : ""
                      }
        }
        
# 还原喜欢信息(POST /api/comment/{$id}/resLike)
    +Parameters : 
        {$comment_id} :  评论的id
    +Response :
        {
            "errCode" : code,
            "errMsg": "msg",
            "data" : {
                        "id" : id
                      }
        }

# 添加评论信息 (POST /api/comment/addComment)
    +Parameters : 
        * {$food_id} :  菜品的id
        * {$vote} : 踩或者贊 (0 1)
        * {$comment} :  评论的内容
        * {$imgs} : 上传的照片
    +Response :
        {
            'errCode': code,
            "errMsg" : "msg",
            "data" : {
                        "id" : "",
                        "vote" : "",
                        "comment" : "",
                        "food_id" : "",
                        "user_id" : "",
                        "imgurls" : {
                                        {"id" : "", "imgurl" : ""}
                                        {"id" : "", "imgurl" : ""}
                                    }
                      }
        }
        
# 查看评论信息 (Get /api/comment/{$comment_id})
    +Parameters : 
        * {$comment_id} : 评论的id
    +Response :
        {
            "errCode" : code,
            "errMsg" : "msg",
            "data" :    {
                            "id" : "",
                            "vote" : "",
                            "comment" : "",
                            "food_id" : "",
                            "user_id" : "",
                            "imgurls" : {
                                            {"id" : "", "imgurl" : ""}
                                            {"id" : "", "imgurl" : ""}
                                         }
                        }
        }
       
# 查看菜品的评论 (GET /api/food/{$food_id}/comment/{$sequence}/all/pagesize/{$pagesize}?page={$page})
    +Parameters :
        + {$food_id} : 菜品的id
        + {$sequence} : 
            * asc  升序
            * desc 降序
        + {$pagesize} :
            > 自定义每页返回数量(>0)  默认为 30 
        + {$page} :
            > 数据的页数
    +Response :
        {
            "errCode" : code,
            "errMsg" : "msg",
            "data" :    {
                            "food_id" : "",
                            "comments" :    {
                                                {
                                                    "id" : "",
                                                    "vote" : "",
                                                    "comment" : "",
                                                    "user_id" : "",
                                                    "imgurls" :     {
                                                                        { "id" : "" , "imgurl" : ""}
                                                                        { "id" : "" , "imgurl" : ""}
                                                                    }
                                                }
                                                {
                                                    "id" : "",
                                                    "vote" : "",
                                                    "comment" : "",
                                                    "user_id" : "",
                                                }
                                            }
                        }
        }