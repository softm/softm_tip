/*
// 로직파일 작성방법
// 계층구조로 Json형태로 매핑한다.
    ElmentID:{
        OPTION_IF_CORRECT:'continue',
        source:['ElmentID'], <-- 선택적으로 이용됨
        'if==1':{
            set:[{object:'passengers',value:'Math.round($("E5005").options[$("E5005").selectedIndex].text/68,0)'}]
        }
    },
    map:{
        ElmentID :['ElmentID1','ElmentID2'],
    }

    * attribute
        ElmentID            : 로직의 ElementID로 반드시 DOM.id값이여만한다
                              ElmentID값이 선언되면 logicJson.ElementID로직을 반드시 실행한다.
            OPTION_IF_CORRECT   : if조건절 처리와 연속하여 로직Element를 실행하게하려면 continue를 설정해야한다.
                                  [stop(default)/continue]
        LogicID             : L로 시작하며 로직을 처리할때 선언한다.
        if조건절            : 조건절
            source              : 조건절(if로시작) attribute과 연관된 Element ID
                                  지정하지 않으면 상위 ElementID값이 source가된다.
            set                 : object,value를 속성으로하는 배열
                                  --> set:[{object:'car_width',value:'(1400).format()'},{object:'car_depth',value:'(800).format()' },{object:'hoistway_width',value:'(1800).format()'},{object:'hoistway_depth',value:'(1450).format()'}]

        * 참고
            속도를 높이기위해서는 ElmentID Attribute의 위치를 if Item 위에 위치시킨다.
*/
var logicJson = {
    E5007:{
        'if==1':{
            set:[{object:'passengers',value:'Math.round($("E5005").options[$("E5005").selectedIndex].text/68,0)'}]
        },
        'if!=1':{
            set:[{object:'passengers',value:'Math.round($("E5005").options[$("E5005").selectedIndex].text/75,0)'}]
        }
    },

    E5006:{
        OPTION_IF_CORRECT:'continue',
        set:[{object:'velocity',value:'$("E5006").options[$("E5006").selectedIndex].text/60'}],
        //source:['E5006'],
        'if==1':{ // =IF(E14>60,"Oil buffer","Urethane buffer")
            set:[{object:'buffer',value:'"Urethane buffer"'}]
        },
        'if!=1':{ // =IF(E14>60,"Oil buffer","Urethane buffer")
            set:[{object:'buffer',value:'"Oil buffer"'}]
        },
        OPTION_IF_CORRECT:'continue',
        L5007:{
            source:['E5007','E5006','velocity'],
            'if==1_==1_==1.00' :{set:[{object:'E5010',value:"(3800).format()"},{object:'E5011',value:"(1450).format()"}]},
            'if==1_==2_==1.50' :{set:[{object:'E5010',value:"(3950).format()"},{object:'E5011',value:"(1800).format()"}]},
            'if==1_==3_==1.75' :{set:[{object:'E5010',value:"(4050).format()"},{object:'E5011',value:"(2100).format()"}]},
            'if!=1_==1_==1.00' :{set:[{object:'E5010',value:"(3800).format()"},{object:'E5011',value:"(1450).format()"}]},
            'if!=1_==2_==1.50' :{set:[{object:'E5010',value:"(3950).format()"},{object:'E5011',value:"(1800).format()"}]},
            'if!=1_==3_==1.75' :{set:[{object:'E5010',value:"(4050).format()"},{object:'E5011',value:"(2100).format()"}]}
        }
    },

    E5063:{
        E5081:{
            source:['E5063','E5081'],
            'if==1_==1':{set:[{object:'E5003',value:'1'},{object:'E5004',value:'1'}]},
            'if==1_!=1':{set:[{object:'E5003',value:'2'},{object:'E5004',value:'1'}]},
            'if!=1_==1':{set:[{object:'E5003',value:'1'},{object:'E5004',value:'2'}]},
            'if!=1_!=1':{set:[{object:'E5003',value:'2'},{object:'E5004',value:'2'}]}
        },
        source:['E5063','cop_button'],
        'if==1_==1':{set:[{object:'E5074',value:2  }]},
        'if==1_==2':{set:[{object:'E5074',value:4  }]},
        'if==1_==3':{set:[{object:'E5074',value:6  }]},
        'if==1_==4':{set:[{object:'E5074',value:12 }]},
        'if==1_==5':{set:[{object:'E5074',value:14 }]},
        'if==1_==6':{set:[{object:'E5074',value:16 }]},
        'if==2_==1':{set:[{object:'E5074',value:3  }]},
        'if==2_==2':{set:[{object:'E5074',value:5  }]},
        'if==2_==3':{set:[{object:'E5074',value:7  }]},
        'if==2_==4':{set:[{object:'E5074',value:13 }]},
        'if==2_==5':{set:[{object:'E5074',value:15 }]},
        'if==2_==6':{set:[{object:'E5074',value:17 }]},
        'if==3_==1':{set:[{object:'E5074',value:3  }]},
        'if==3_==2':{set:[{object:'E5074',value:5  }]},
        'if==3_==3':{set:[{object:'E5074',value:7  }]},
        'if==3_==4':{set:[{object:'E5074',value:13 }]},
        'if==3_==5':{set:[{object:'E5074',value:15 }]},
        'if==3_==6':{set:[{object:'E5074',value:17 }]},
        'if==4_==1':{set:[{object:'E5074',value:3  }]},
        'if==4_==2':{set:[{object:'E5074',value:5  }]},
        'if==4_==3':{set:[{object:'E5074',value:7  }]},
        'if==4_==4':{set:[{object:'E5074',value:13 }]},
        'if==4_==5':{set:[{object:'E5074',value:15 }]},
        'if==4_==6':{set:[{object:'E5074',value:17 }]},
        'if==5_==1':{set:[{object:'E5074',value:3  }]},
        'if==5_==2':{set:[{object:'E5074',value:5  }]},
        'if==5_==3':{set:[{object:'E5074',value:7  }]},
        'if==5_==4':{set:[{object:'E5074',value:13 }]},
        'if==5_==5':{set:[{object:'E5074',value:15 }]},
        'if==5_==6':{set:[{object:'E5074',value:17 }]}
    },
/*
    E5074:{
        set:[{object:'E5074_COPY',value:'$("E5074").options[$("E5074").selectedIndex].text'}]
    },
설계팀 삭제*/

    cop_button:{
        set:[{object:'cop_button_copy',value:'$("cop_button").options[$("cop_button").selectedIndex].value'}]
    },

    Lspecification:{
        set:[{object:'specification',value:"'P' +  $('E5005').options[$('E5005').selectedIndex].text + '-' + $('E5020').options[$('E5020').selectedIndex].text.substring(0,2) + $('E5006').options[$('E5006').selectedIndex].text + '-' + $('E5009').value.toNumber() + '/' + $('E5008').value.toNumber()"}]
    },

    specifications_floor:{
        'if==1':{set:[{object:'E5105',value:'2'},{object:'E5106',value:'30'}]},
        'if==2':{set:[{object:'E5105',value:'2'},{object:'E5106',value:'25'}]},
        'if==3':{set:[{object:'E5105',value:'2'},{object:'E5106',value:'20'}]},
        'if==4':{set:[{object:'E5105',value:'1'},{object:'E5106',value:'2' }]},
        'if==5':{set:[{object:'E5105',value:'1'},{object:'E5106',value:'2' }]}
    },

    door_ground:{
        source:['door_ground','transom_ground'],
        'if==1_=="E"':{set:[{object:'E5019',value:'9' },{object:'E5021',value:'1'}]},
        'if==2_=="E"':{set:[{object:'E5019',value:'1' },{object:'E5021',value:'1'}]},
        'if==3_=="E"':{set:[{object:'E5019',value:'3' },{object:'E5021',value:'1'}]},
        'if==4_=="E"':{set:[{object:'E5019',value:'2' },{object:'E5021',value:'1'}]},
        'if==5_=="E"':{set:[{object:'E5019',value:'4' },{object:'E5021',value:'1'}]},
        'if==6_=="E"':{set:[{object:'E5019',value:'4' },{object:'E5021',value:'1'}]},
        'if==1_=="I"':{set:[{object:'E5019',value:'20'},{object:'E5021',value:'1'}]},
        'if==2_=="I"':{set:[{object:'E5019',value:'12'},{object:'E5021',value:'1'}]},
        'if==3_=="I"':{set:[{object:'E5019',value:'14'},{object:'E5021',value:'1'}]},
        'if==4_=="I"':{set:[{object:'E5019',value:'13'},{object:'E5021',value:'1'}]},
        'if==5_=="I"':{set:[{object:'E5019',value:'15'},{object:'E5021',value:'1'}]},
        'if==6_=="I"':{set:[{object:'E5019',value:'15'},{object:'E5021',value:'1'}]},
        'if==7'      :{set:[{object:'E5019',value:'1' },{object:'E5021',value:'1'}]}

    },
    door_typical:{
        source:['door_typical','transom_typical'],
        'if==1_=="E"':{set:[{object:'E5022',value:'9' },{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==2_=="E"':{set:[{object:'E5022',value:'1' },{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==3_=="E"':{set:[{object:'E5022',value:'3' },{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==4_=="E"':{set:[{object:'E5022',value:'2' },{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==5_=="E"':{set:[{object:'E5022',value:'4' },{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==6_=="E"':{set:[{object:'E5022',value:'4' },{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==1_=="I"':{set:[{object:'E5022',value:'20'},{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==2_=="I"':{set:[{object:'E5022',value:'12'},{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==3_=="I"':{set:[{object:'E5022',value:'14'},{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==4_=="I"':{set:[{object:'E5022',value:'13'},{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==5_=="I"':{set:[{object:'E5022',value:'15'},{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==6_=="I"':{set:[{object:'E5022',value:'15'},{object:'E5023',value:'$("E5009").value.toNumber()-1'}]},
        'if==7'      :{set:[{object:'E5022',value:'1' },{object:'E5023',value:'0'}                            ]}
    },

    jamb_ground:{
        source:['jamb_ground','jamb_ground_option','transom_ground'],
        'if==2_=="W"_=="E"':{set:[{object:'E5026',value:'9' },{object:'E5027',value:'1'}]},
        'if==4_=="W"_=="E"':{set:[{object:'E5026',value:'10'},{object:'E5027',value:'1'}]},
        'if==6_=="W"_=="E"':{set:[{object:'E5026',value:'11'},{object:'E5027',value:'1'}]},
        'if==2_=="N"_=="E"':{set:[{object:'E5026',value:'1' },{object:'E5027',value:'1'}]},
        'if==4_=="N"_=="E"':{set:[{object:'E5026',value:'2' },{object:'E5027',value:'1'}]},
        'if==6_=="N"_=="E"':{set:[{object:'E5026',value:'3' },{object:'E5027',value:'1'}]},
        'if==2_=="W"_=="I"':{set:[{object:'E5026',value:'17'},{object:'E5027',value:'1'}]},
        'if==4_=="W"_=="I"':{set:[{object:'E5026',value:'18'},{object:'E5027',value:'1'}]},
        'if==6_=="W"_=="I"':{set:[{object:'E5026',value:'19'},{object:'E5027',value:'1'}]},
        'if==2_=="N"_=="I"':{set:[{object:'E5026',value:'1' },{object:'E5027',value:'1'}]},
        'if==4_=="N"_=="I"':{set:[{object:'E5026',value:'2' },{object:'E5027',value:'1'}]},
        'if==6_=="N"_=="I"':{set:[{object:'E5026',value:'3' },{object:'E5027',value:'1'}]},
        'if==7'            :{set:[{object:'E5026',value:'1' },{object:'E5027',value:'1'}]}
    },

    jamb_typical:{
        source:['jamb_typical','jamb_typical_option','transom_typical'],
        'if==2_=="W"_=="E"':{set:[{object:'E5028',value:'9' },{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==4_=="W"_=="E"':{set:[{object:'E5028',value:'10'},{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==6_=="W"_=="E"':{set:[{object:'E5028',value:'11'},{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==2_=="N"_=="E"':{set:[{object:'E5028',value:'1' },{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==4_=="N"_=="E"':{set:[{object:'E5028',value:'2' },{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==6_=="N"_=="E"':{set:[{object:'E5028',value:'3' },{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==2_=="W"_=="I"':{set:[{object:'E5028',value:'17'},{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==4_=="W"_=="I"':{set:[{object:'E5028',value:'18'},{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==6_=="W"_=="I"':{set:[{object:'E5028',value:'19'},{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==2_=="N"_=="I"':{set:[{object:'E5028',value:'1' },{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==4_=="N"_=="I"':{set:[{object:'E5028',value:'2' },{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==6_=="N"_=="I"':{set:[{object:'E5028',value:'3' },{object:'E5029',value:'$("E5009").value.toNumber()-1'}]},
        'if==7'            :{set:[{object:'E5028',value:'1' },{object:'E5029',value:'0'}                            ]}
    },

    E5010:{// Travel, Overhead, Pit
        set:
            [
                {object:'E5094',value:'Math.round(($("E5012").value.toNumber() + $("E5010").value.toNumber() + $("E5011").value.toNumber()) / $("car_side").value.toNumber())'},
                {object:'E5013',value:'($("E5012").value.toNumber() + $("E5010").value.toNumber() + $("E5011").value.toNumber())'}
            ]
    },
    E5011:{// Travel, Overhead, Pit
        set:
            [
                {object:'E5094',value:'Math.round(($("E5012").value.toNumber() + $("E5010").value.toNumber() + $("E5011").value.toNumber()) / $("car_side").value.toNumber())'},
                {object:'E5013',value:'($("E5012").value.toNumber() + $("E5010").value.toNumber() + $("E5011").value.toNumber())'}
            ]
    },
    E5012:{// Travel, Overhead, Pit
        set:
            [
                {object:'E5094',value:'Math.round(($("E5012").value.toNumber() + $("E5010").value.toNumber() + $("E5011").value.toNumber()) / $("car_side").value.toNumber())'},
                {object:'E5013',value:'($("E5012").value.toNumber() + $("E5010").value.toNumber() + $("E5011").value.toNumber())'}
            ]
    },

    car_side:{// Travel, Overhead, Pit
        set:
            [
                {object:'E5094',value:'Math.round(($("E5012").value.toNumber() + $("E5010").value.toNumber() + $("E5011").value.toNumber()) / $("car_side").value.toNumber())'}
            ]
    },

    cage_panel_n_wall:{
        'if==1':{set:[{object:'E5035',value:'9'}]},
        'if==2':{set:[{object:'E5035',value:'1'}]},
        'if==3':{set:[{object:'E5035',value:'3'}]},
        'if==4':{set:[{object:'E5035',value:'2'}]},
        'if==5':{set:[{object:'E5035',value:'4'}]},
        'if==6':{set:[{object:'E5035',value:'4'}]},
        'if==7':{set:[{object:'E5035',value:'1'}]}
    },

    car_door:{
        'if==1':{set:[{object:'E5041',value:'9'}]},
        'if==2':{set:[{object:'E5041',value:'1'}]},
        'if==3':{set:[{object:'E5041',value:'3'}]},
        'if==4':{set:[{object:'E5041',value:'2'}]},
        'if==5':{set:[{object:'E5041',value:'4'}]},
        'if==6':{set:[{object:'E5041',value:'4'}]},
        'if==7':{set:[{object:'E5041',value:'1'}]}
    },
    open_through_car:{
        'if=="No"' :{set:[{object:'E5190',value:'1'}]},
        'if=="Yes"':{set:[{object:'E5190',value:'2'}]}
    },
    passengers:{  //( Excel 로직 )
        OPTION_IF_CORRECT:'continue',
        source:['passengers','passengers'],
        'if>=6_<=12' :{set:[{object:'std_entrance_door_width',value:800 },{object:'entrance_door_width',value:800 }]},
        'if>=13_<=15':{set:[{object:'std_entrance_door_width',value:900 },{object:'entrance_door_width',value:900 }]},
        'if>=16_<=20':{set:[{object:'std_entrance_door_width',value:1000},{object:'entrance_door_width',value:1000}]},
        'if>=22'     :{set:[{object:'std_entrance_door_width',value:1100},{object:'entrance_door_width',value:1100}]},
        L5007:{
            source:['E5007'],
            'if==1':{
                passengers:{
                    'if==8 ':{set:[{object:'E5005',value:1},{object:'car_width',value:'(1100).format()'},{object:'car_depth',value:'(1300).format()'},{object:'hoistway_width',value:'(1850).format()'},{object:'hoistway_depth',value:'(1700).format()'}]},
                    'if==9 ':{set:[{object:'E5005',value:2},{object:'car_width',value:'(1100).format()'},{object:'car_depth',value:'(1400).format()'},{object:'hoistway_width',value:'(1850).format()'},{object:'hoistway_depth',value:'(1800).format()'}]},
                    'if==10':{set:[{object:'E5005',value:3},{object:'car_width',value:'(1300).format()'},{object:'car_depth',value:'(1300).format()'},{object:'hoistway_width',value:'(1950).format()'},{object:'hoistway_depth',value:'(1700).format()'}]},
                    'if==11':{set:[{object:'E5005',value:4},{object:'car_width',value:'(1300).format()'},{object:'car_depth',value:'(1400).format()'},{object:'hoistway_width',value:'(1950).format()'},{object:'hoistway_depth',value:'(1800).format()'}]},
                    'if==13':{set:[{object:'E5005',value:5},{object:'car_width',value:'(1500).format()'},{object:'car_depth',value:'(1400).format()'},{object:'hoistway_width',value:'(2150).format()'},{object:'hoistway_depth',value:'(1800).format()'}]},
                    'if==15':{set:[{object:'E5005',value:6},{object:'car_width',value:'(1600).format()'},{object:'car_depth',value:'(1400).format()'},{object:'hoistway_width',value:'(2200).format()'},{object:'hoistway_depth',value:'(1800).format()'}]}
                }
            },
            'if!=1':{
                passengers:{
                    'if==8 ':{set:[{object:'E5005',value:1},{object:'car_width',value:'(1100).format()'},{object:'car_depth',value:'(1300).format()'},{object:'hoistway_width',value:'(1850).format()'},{object:'hoistway_depth',value:'(1700).format()'}]},
                    'if==9 ':{set:[{object:'E5005',value:2},{object:'car_width',value:'(1100).format()'},{object:'car_depth',value:'(1400).format()'},{object:'hoistway_width',value:'(1850).format()'},{object:'hoistway_depth',value:'(1800).format()'}]},
                    'if==10':{set:[{object:'E5005',value:3},{object:'car_width',value:'(1300).format()'},{object:'car_depth',value:'(1300).format()'},{object:'hoistway_width',value:'(1950).format()'},{object:'hoistway_depth',value:'(1700).format()'}]},
                    'if==11':{set:[{object:'E5005',value:4},{object:'car_width',value:'(1300).format()'},{object:'car_depth',value:'(1400).format()'},{object:'hoistway_width',value:'(1950).format()'},{object:'hoistway_depth',value:'(1800).format()'}]},
                    'if==13':{set:[{object:'E5005',value:5},{object:'car_width',value:'(1500).format()'},{object:'car_depth',value:'(1400).format()'},{object:'hoistway_width',value:'(2150).format()'},{object:'hoistway_depth',value:'(1800).format()'}]},
                    'if==15':{set:[{object:'E5005',value:6},{object:'car_width',value:'(1600).format()'},{object:'car_depth',value:'(1400).format()'},{object:'hoistway_width',value:'(2200).format()'},{object:'hoistway_depth',value:'(1800).format()'}]}
                }
            }
        }
    },

    car_height:{ // if($("car_height").value==2100,2000,$("car_height").value-200) ( Excel 로직 )
        //'if==2100' :{set:[{object:'entrance_door_height',value:'(2000 ).format()'}]},
        //'if!=2100' :{set:[{object:'entrance_door_height',value:'($("car_height").value.toNumber()-200 ).format()'}]}
        OPTION_IF_CORRECT:'continue',
        'if==2100' :{set:[{object:'entrance_door_height',value:2000}]},
        'if!=2100' :{set:[{object:'entrance_door_height',value:'$("car_height").value.toNumber()-200'}]},

        'if==2100' :{set:[{object:'E5183',value:1}]},
        'if==2200' :{set:[{object:'E5183',value:1}]},
        'if==2300' :{set:[{object:'E5183',value:1}]},
        'if==2400' :{set:[{object:'E5183',value:1}]},
        'if==2500' :{set:[{object:'E5183',value:1}]}
    },


    fire_resistance_application :{
        'if==1'  :{set:[{object:'E5191',value:'1'}]},
        'if==2'  :{set:[{object:'E5191',value:'2'}]},
        'if==3'  :{set:[{object:'E5191',value:'3'}]}
    },

    entrance_door_height:{
        source:['entrance_door_height','entrance_door_height'],
        'if==2000'          :{set:[{object:'E5182',value:'1'}]},
        'if==2100'          :{set:[{object:'E5182',value:'1'}]},
        'if==2200'          :{set:[{object:'E5182',value:'2'}]},
        'if==2300'          :{set:[{object:'E5182',value:'3'}]}
    },

    map:{
        E5007                   :['E5007','E5006'],
        E5006                   :['E5006','Lspecification'],
        E5005                   :['E5007','Lspecification'],
        E5020                   :['E5020','Lspecification'],
        E5009                   :['E5009','Lspecification'],
        E5008                   :['E5008','Lspecification'],
        E5063                   :['E5063'],
        specifications_floor    :['specifications_floor'],

        door_ground             :['door_ground'],
        transom_ground          :['door_ground','jamb_ground'],
        code_of_fireman_lift    :['door_ground','door_typical','jamb_ground','jamb_typical'],

        door_typical            :['door_typical','jamb_ground'],
        transom_typical         :['door_typical','jamb_typical'],

        jamb_ground             :['jamb_ground'],
        jamb_ground_option      :['jamb_ground'],

        jamb_typical            :['jamb_typical'],
        jamb_typical_option     :['jamb_typical'],

        cage_panel_n_wall       :['cage_panel_n_wall'],
        car_door                :['car_door'],
        counter_weight_safety   :['counter_weight_safety'],
        open_through_car        :['open_through_car'],
        fire_resistance_application :['fire_resistance_application' ],
        entrance_door_height    :['entrance_door_height' ],

        car_height              :['car_height'],

        E5010                   :['E5010'],
        E5011                   :['E5011'],
        E5012                   :['E5012'],
        car_side                :['car_side']

        // 설계팀 삭제 :: E5074                   :['E5074']
    }
};
// 아래처럼도 로직 설정가능함.
//logicJson['E5010'] = logicJson['E5007'];

/* ---- 적용로직
    E5061 : 1,2항목만 보임
    E5075 : 1,2항목만 보임
    E5072 : 삭제항목2,5,8,12,17,19,22,25 안보임
    E5071 : 홀수 인수만 적용(1,3,5,7,9…)
    E5017 : CSA 인증제품 적용1,(2),5만 표시 // 로직해제 요청 ( 2009-11-12 : 설계팀 )
*/

var adjustItemJson = {
    E5061:{INCLUDE:[1,2]},
    E5072:{EXCLUDE:[2,5,8,12,17,19,22,25]},
    E5075:{INCLUDE:[1,2]},
    E5071:{LOGIC:'%2==1'}
    // E5017:{INCLUDE:[1,2,5]} //로직해제 요청 ( 2009-11-12 : 설계팀 )
};

var optionAmountJson = {
    car_height:{
        source:['car_height','car_height'],
        'if<=2200'          :{set:[{object:'opt_amt_car_height',value:'440000 * $("total_unit").value.toNumber()'}]},
        'if>=2300_<=2400'   :{set:[{object:'opt_amt_car_height',value:'110000 * $("total_unit").value.toNumber()'}]},
        'if'                :{set:[{object:'opt_amt_car_height',value:'0'}]}
    },
    entrance_door_width:{
        set:[{object:'opt_amt_entrance_door_width',value:'Math.round(($("entrance_door_width").value.toNumber() - $("std_entrance_door_width").value.toNumber()) / 100,0) * ( $("E5008").value.toNumber() + 1) * 110000 * $("total_unit").value.toNumber()'}]
    },
    entrance_door_height:{
        source:['entrance_door_height','entrance_door_height'],
        'if<=2500'          :{set:[{object:'opt_amt_entrance_door_height',value:'110000 * ( $("E5008").value.toNumber() + 1) * $("total_unit").value.toNumber()'}]},
        'if>=2700_<=2750'   :{set:[{object:'opt_amt_entrance_door_height',value:'220000 * ( $("E5008").value.toNumber() + 1) * $("total_unit").value.toNumber()'}]},
        'if'                :{set:[{object:'opt_amt_entrance_door_height',value:'0'}]}
    },

    E5052                       :{ 'if!=1'  :{set:[{object:'opt_amt_E5052',value:'220000 * $("total_unit").value.toNumber()'}]},'if':{set:[{object:'opt_amt_E5052'  ,value:'0'}]}},

    fireman_emergency_return    :{ 'if=="I"':{set:[{object:'opt_amt_fireman_emergency_return'  ,value:'385000 * $("total_unit").value.toNumber()'}]},'if':{set:[{object:'opt_amt_fireman_emergency_return'  ,value:'0'}]}},
    E5081                       :{ 'if!=1'  :{set:[{object:'opt_amt_E5081'                     ,value:'385000 * $("total_unit").value.toNumber()'}]},'if':{set:[{object:'opt_amt_E5081'                     ,value:'0'}]}},
    emergency_power_operation   :{ 'if=="I"':{set:[{object:'opt_amt_emergency_power_operation' ,value:'550000 * $("total_unit").value.toNumber()'}]},'if':{set:[{object:'opt_amt_emergency_power_operation' ,value:'0'}]}},
    E5144                       :{ 'if!=1'  :{set:[{object:'opt_amt_E5144',                     value:'220000 * 1'                               }]},'if':{set:[{object:'opt_amt_E5144',                     value:'0'}]}},
    by_pass_operation           :{ 'if=="I"':{set:[{object:'opt_amt_by_pass_operation'         ,value:'220000 * 1'                               }]},'if':{set:[{object:'opt_amt_by_pass_operation'         ,value:'0'}]}},
    night_time_operation        :{ 'if=="I"':{set:[{object:'opt_amt_night_time_operation'      ,value:'220000 * 1'                               }]},'if':{set:[{object:'opt_amt_night_time_operation'      ,value:'0'}]}},
    isolated_simplex_operation  :{ 'if=="I"':{set:[{object:'opt_amt_isolated_simplex_operation',value:'220000 * 1'                               }]},'if':{set:[{object:'opt_amt_isolated_simplex_operation',value:'0'}]}},
    E5130                       :{ 'if!=1'  :{set:[{object:'opt_amt_E5130'                     ,value:'1430000* $("total_unit").value.toNumber()'}]},'if':{set:[{object:'opt_amt_E5130'                     ,value:'0'}]}},

    bms_interface               :{
        source:['E5007','bms_interface'],
        'if==1_=="I"'  :{set:[{object:'opt_amt_bms_interface',value:'110000 * 1'}]},
        'if==2_=="I"'  :{set:[{object:'opt_amt_bms_interface',value:'330000 * 1'}]},
        'if==3_=="I"'  :{set:[{object:'opt_amt_bms_interface',value:'330000 * 1'}]},
        'if'           :{set:[{object:'opt_amt_bms_interface',value:'0'}]}
    },
    // 해영 <-- 로직에서 제거...
/*
    E5043                       :{ 'if!=1'  :{set:[{object:'opt_amt_E5043'                     ,value:'385000 * 1'}]},
                                   'if'     :{set:[{object:'opt_amt_E5043',value:'0'}]}
    },
*/
    E5109               :{
        source:['E5007','E5109'],
        'if==1_=="I"'  :{set:[{object:'opt_amt_E5109',value:'880000  * 1'}]},
        'if==2_=="I"'  :{set:[{object:'opt_amt_E5109',value:'2200000 * 1'}]},
        'if==3_=="I"'  :{set:[{object:'opt_amt_E5109',value:'2200000 * 1'}]},
        'if'           :{set:[{object:'opt_amt_E5109',value:'0'}]}
    },

    open_through_car            :{ 'if=="Yes"' :{set:[{object:'opt_amt_open_through_car',value:'3850000* $("total_unit").value.toNumber()'}]},
                                   'if=="No"'  :{set:[{object:'opt_amt_open_through_car',value:'0'}]}},

    map:{
        car_height                  :['car_height'                  ],
        entrance_door_width         :['entrance_door_width'         ],
        entrance_door_height        :['entrance_door_height'        ],
        E5052                       :['E5052'                       ],
        fireman_emergency_return    :['fireman_emergency_return'    ],
        E5081                       :['E5081'                       ],
        emergency_power_operation   :['emergency_power_operation'   ],
        E5144                       :['E5144'                       ],
        by_pass_operation           :['by_pass_operation'           ],
        night_time_operation        :['night_time_operation'        ],
        isolated_simplex_operation  :['isolated_simplex_operation'  ],
        E5130                       :['E5130'                       ],

        bms_interface               :['bms_interface'               ],
      //E5043                       :['E5043'                       ],
        E5109                       :['E5109'                       ],
        open_through_car            :['open_through_car'            ],

        // 층수
        E5008                   :[
                                  'car_height',
                                  'entrance_door_width',
                                  'entrance_door_height',
                                  'E5052',
                                  'fireman_emergency_return',
                                  'E5081',
                                  'emergency_power_operation',
                                  'E5144',
                                  'by_pass_operation',
                                  'night_time_operation',
                                  'isolated_simplex_operation',
                                  'E5130',
                                  'bms_interface',
                                //'E5043',
                                  'E5109',
                                  'open_through_car'
                                 ],
        // 대수
        total_unit              :[
                                  'car_height',
                                  'entrance_door_width',
                                  'entrance_door_height',
                                  'E5052',
                                  'fireman_emergency_return',
                                  'E5081',
                                  'emergency_power_operation',
                                  'E5144',
                                  'by_pass_operation',
                                  'night_time_operation',
                                  'isolated_simplex_operation',
                                  'E5130',
                                  'bms_interface',
                                //'E5043',
                                  'E5109',
                                  'open_through_car'
                                 ]
    }
};
/*
        source:['E5007','car_height','car_height'],
        'if==1_<=2500':"440000 * 1",'if==1_>=2700_<=2750':"110000 * 1",
        'if==2_<=2500':"440000 * 1",'if==2_>=2700_<=2750':"110000 * 1",
        'if==3_<=2500':"440000 * 1",'if==3_>=2700_<=2750':"110000 * 1"
*/
