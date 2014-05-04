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
@synthesize aLabel;

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
    
    int val=0;
    if ([object isEqualToString:@"LampeBC"])
    {
        if (activated)
        {
            val=1;
        }
        else
        {
            val=11;
        }
    }
    else if ([object isEqualToString:@"LampeHalo"])
    {
        if (activated)
        {
            val=2;
        }
        else
        {
            val=22;
		}
    }
    else if ([object isEqualToString:@"TV"])
    {
        if (activated)
        {
            val=3;
        }
        else
        {
            val=33;
        }
    }
    else if ([object isEqualToString:@"LampeChevet"])
    {
        if (activated)
        {
            val=4;
        }
        else
        {
            val=44;            
        }
    }
	
    NSString * post = [[NSString alloc] initWithFormat:@"&relais=%d", val];
    NSData * postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:NO];
    NSString *postLength = [NSString stringWithFormat:@"%lu",(unsigned long)[postData length]]; //J'ai remplacé par %lu car c'était le format adéquat mais tu peux le remettre en %d sinon
    NSMutableURLRequest * request = [[NSMutableURLRequest alloc] init];
	
	NSDictionary *dict = [NSDictionary dictionaryWithContentsOfFile:[[NSBundle mainBundle] pathForResource:@"Server" ofType:@"plist"]];
	NSString *ip = [dict objectForKey:@"LastIP"];
	ip = [NSString stringWithFormat:@"http://%@/index.py", ip];
	NSLog(@"IP :%@", ip);
	
	[request setURL:[NSURL URLWithString:ip]];
	[request setHTTPMethod:@"POST"];
    [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
    [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPBody:postData];
    NSURLConnection *conn = [[NSURLConnection alloc] initWithRequest:request delegate:self];
    
    if (conn)
		NSLog(@"Succès ! Le reste se déroule sur le serveur");
    
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


@end

