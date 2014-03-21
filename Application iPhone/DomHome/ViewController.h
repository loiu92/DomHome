//
//  ViewController.h
//  DomHome
//
//  Created by Lucas Ruelle on 13/12/2013.
//  Copyright (c) 2013 Loiu92. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface ViewController : UIViewController <NSURLConnectionDelegate>

- (IBAction)lampeBC:(UISwitch *)sender;
- (IBAction)lampeHalo:(UISwitch *)sender;
- (IBAction)TV:(UISwitch *)sender;
- (IBAction)lampeChevet:(UISwitch *)sender;
- (IBAction)lampePlafond:(UISwitch *)sender;
- (IBAction)lampeChevet2:(UISwitch *)sender;
- (IBAction)TV2:(UISwitch *)sender;

@end
