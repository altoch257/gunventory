using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Gunventory.Data;
using Gunventory.Models;
using Microsoft.AspNetCore.Authorization;
using System.ComponentModel.DataAnnotations;

namespace Gunventory.Pages;

[Authorize]
public class AddAccessoryModel : PageModel
{
    private readonly GunventoryContext _context;
    private readonly IWebHostEnvironment _environment;

    public AddAccessoryModel(GunventoryContext context, IWebHostEnvironment environment)
    {
        _context = context;
        _environment = environment;
    }

    [BindProperty]
    public InputModel Input { get; set; } = new();

    public SelectList Firearms { get; set; } = default!;

    public class InputModel
    {
        [Required]
        [MaxLength(50)]
        public string Manufacturer { get; set; } = string.Empty;

        [Required]
        [MaxLength(50)]
        public string Model { get; set; } = string.Empty;

        [Required]
        [Display(Name = "Firearm")]
        public int FirearmId { get; set; }

        [Required]
        [DataType(DataType.Date)]
        public DateTime PurchaseDate { get; set; } = DateTime.Now;

        public decimal Price { get; set; }

        public string? Details { get; set; }

        public IFormFile? Image { get; set; }
    }

    public void OnGet()
    {
        Firearms = new SelectList(_context.Firearms.Where(f => f.Status == "A"), "Id", "Model");
    }

    public async Task<IActionResult> OnPostAsync()
    {
        if (!ModelState.IsValid)
        {
            Firearms = new SelectList(_context.Firearms.Where(f => f.Status == "A"), "Id", "Model");
            return Page();
        }

        var accessory = new Accessory
        {
            Manufacturer = Input.Manufacturer,
            Model = Input.Model,
            FirearmId = Input.FirearmId,
            PurchaseDate = Input.PurchaseDate,
            Price = Input.Price,
            Details = Input.Details,
            Status = "A",
            STimestamp = DateTime.Now
        };

        if (Input.Image != null)
        {
            accessory.ImgURL = await SaveFile(Input.Image, "img/uploads");
        }

        _context.Accessories.Add(accessory);
        await _context.SaveChangesAsync();

        return RedirectToPage("/FirearmDetails", new { id = Input.FirearmId });
    }

    private async Task<string> SaveFile(IFormFile file, string subDir)
    {
        var fileName = Path.GetFileNameWithoutExtension(file.FileName) + "_" + DateTimeOffset.UtcNow.ToUnixTimeSeconds() + Path.GetExtension(file.FileName);
        var filePath = Path.Combine(_environment.WebRootPath, subDir, fileName);

        Directory.CreateDirectory(Path.GetDirectoryName(filePath)!);

        using (var stream = System.IO.File.Create(filePath))
        {
            await file.CopyToAsync(stream);
        }

        return $"./{subDir}/{fileName}";
    }
}
