



##201016

- spatie/icalendar-generatorを使用
    [spatie](https://github.com/spatie/icalendar-generator)
    
- 参考
 - [iCalendar 仕様](http://www.asahi-net.or.jp/~CI5M-NMR/iCal/ref.html)  
 - [markdown書き方quita](https://qiita.com/Hase-pro/items/16379a0c83f2725e3a11)
 - [markdown書き方gist](https://gist.github.com/mignonstyle/083c9e1651d7734f84c99b8cf49d57fa)
 
- コードについて
 - 現Concertoベースで作成

 - IcalendarServerInterface
  - send()を定義

 - IcalendarServer 
  - spatieのobjectとマッピング

 - IcalendarObject
  - iCalendar構造
  - add(IcalendarEvent)でEventを追加
  - 
  - 

 - IcalendarEvent
  - iCalendar/Event構造
  - DataContainerValidatableを継承
  - 
  - 
 
 - 
  - 
  - 
  
  
  
 