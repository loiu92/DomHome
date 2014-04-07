//
//  SecondViewController.m
//  DomHome
//
//  Created by Clem on 07/04/14.
//  Copyright (c) 2014 Loiu92. All rights reserved.
//

#import "SecondViewController.h"

@interface SecondViewController ()

@end

@implementation SecondViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self.textField setDelegate:self];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
	NSMutableDictionary *dict = [NSMutableDictionary dictionaryWithContentsOfFile:[[NSBundle mainBundle] pathForResource:@"Server" ofType:@"plist"]];
	[dict setValue:self.textField.text forKey:@"LastIP"];
	[dict writeToFile:[[NSBundle mainBundle] pathForResource:@"Server" ofType:@"plist"] atomically:YES]; //Ecriture de l'IP dans Server.plist
	[textField resignFirstResponder];
	return YES;
}

@end
