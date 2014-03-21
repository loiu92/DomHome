//
//  ViewController.m
//  DomHome
//
//  Created by Lucas Ruelle on 13/12/2013.
//  Copyright (c) 2013 Loiu92. All rights reserved.
//

#import "ViewController.h"

@interface ViewController ()

@end

@implementation ViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)setObject:(NSString *)object activated:(BOOL)activated
{
    //Ceci est la fonction qui s'exécute pour tes UISwitches
    //object est le nom de l'objet et activated est son nouvel état (activé ou non)
    NSDictionary *dict;
    if ([object isEqualToString:@"LampeBC"])
    {
        if (activated)
        {
            dict = @{@"name": @"relais", @"value": @1}; //Allumé
        }
        else
        {
            dict = @{@"name": @"relais", @"value": @11}; //Éteint
        }
    }
    else if ([object isEqualToString:@"LampeHalo"])
    {
        if (activated)
        {
            dict = @{@"name": @"relais", @"value": @2}; //Allumé
        }
        else
        {
            dict = @{@"name": @"relais", @"value": @22}; //Éteint
        }
    }
    NSData *data = [NSKeyedArchiver archivedDataWithRootObject:dict]; //On encapsule le dictionnaire dans les données
    NSMutableURLRequest *request = [[NSMutableURLRequest alloc] initWithURL:[NSURL URLWithString:@"http://pi.loiu92.com/index.py"]];
    [request setHTTPMethod:@"POST"];
    [request setHTTPBody:data];
    [NSURLConnection connectionWithRequest:request delegate:self];
    
}

    
- (IBAction)lampeBC:(UISwitch *)sender
{
    [self setObject:@"LampeBC" activated:sender.on];
}
    
- (IBAction)lampeHalo:(UISwitch *)sender
{
    [self setObject:@"LampeHalo" activated:sender.on];
}
    
- (IBAction)TV:(UISwitch *)sender
{
    [self setObject:@"TV" activated:sender.on];
}
    
- (IBAction)lampeChevet:(UISwitch *)sender
{
    [self setObject:@"LampeChevet" activated:sender.on];
}
    
- (IBAction)lampePlafond:(UISwitch *)sender
{
    [self setObject:@"lampePlafond" activated:sender.on];
}
    
- (IBAction)lampeChevet2:(UISwitch *)sender
{
    [self setObject:@"LampeChevet2" activated:sender.on];
}
    
- (IBAction)TV2:(UISwitch *)sender
{
    [self setObject:@"TV2" activated:sender.on];
}

//NSString * post = [[NSString alloc] initWithFormat:@"&myvariable=%d", 1];
//NSData * postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:NO];
//NSString * postLength = [NSString stringWithFormat:@"%d",[postData length]];
//NSMutableURLRequest * request = [[NSMutableURLRequest alloc] init];
//[request setURL:[NSURL URLWithString:[NSString stringWithFormat:@"http://pi.loiu92.com"]]];
//[request setHTTPMethod:@"POST"];
//[request setValue:postLength forHTTPHeaderField:@"Content-Length"];
//[request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
//[request setHTTPBody:postData];
//NSURLConnection * conn = [[NSURLConnection alloc] initWithRequest:request delegate:self];

//if (conn) NSLog(@"Connection Successful");

@end

